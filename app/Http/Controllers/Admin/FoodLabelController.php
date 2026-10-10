<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodLabelRequest;
use App\Http\Requests\UpdateFoodLabelRequest;
use App\Models\ActivityLog;
use App\Models\ApplicationSetting;
use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FoodLabelController extends Controller
{
    /**
     * Display a listing of the food labels.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');
        $date = $request->query('date');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $sortBy = $request->query('sort_by', 'menu_date');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = FoodLabel::with(['menus', 'creator', 'updater']);

        // Filter status
        if ($status !== 'all' && in_array($status, ['draft', 'scheduled', 'published', 'archived'])) {
            $query->where('status', $status);
        }

        // Search term
        if (! empty($search)) {
            $query->search($search);
        }

        // Specific date filter
        if (! empty($date)) {
            $query->forDate($date);
        }

        // Date range filter
        if (! empty($startDate) || ! empty($endDate)) {
            $query->dateBetween($startDate, $endDate);
        }

        // Sorting
        $allowedSorts = ['menu_date', 'title', 'created_at', 'energy'];
        if (! in_array($sortBy, $allowedSorts)) {
            $sortBy = 'menu_date';
        }
        $sortOrder = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $labels = $query->paginate(10)->withQueryString();

        // Counts for tabs
        $counts = [
            'all' => FoodLabel::count(),
            'published' => FoodLabel::published()->count(),
            'draft' => FoodLabel::draft()->count(),
            'scheduled' => FoodLabel::scheduled()->count(),
            'archived' => FoodLabel::archived()->count(),
        ];

        return view('admin.labels.index', [
            'labels' => $labels,
            'counts' => $counts,
            'currentStatus' => $status,
            'search' => $search,
            'date' => $date,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
        ]);
    }

    /**
     * Show the form for creating a new food label.
     */
    public function create(): View
    {
        return view('admin.labels.create', [
            'defaultDate' => Carbon::today()->format('Y-m-d'),
            'defaultTimeStart' => ApplicationSetting::get('default_consumption_time_start', '08:00'),
            'defaultTimeEnd' => ApplicationSetting::get('default_consumption_time_end', '12:00'),
        ]);
    }

    /**
     * Process an uploaded image: convert to WebP and resize/compress using PHP GD without storage:link.
     */
    private function processImage($image, int $maxWidth = 1000, int $quality = 82): string
    {
        $imageInfo = @getimagesize($image->getPathname());
        $mime = $imageInfo ? $imageInfo['mime'] : $image->getClientMimeType();

        $source = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($image->getPathname()),
            'image/png' => @imagecreatefrompng($image->getPathname()),
            'image/webp' => @imagecreatefromwebp($image->getPathname()),
            default => null,
        };

        $uploadDir = storage_path('uploads/food-labels');
        if (! File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true, true);
        }

        if (! $source || ! $imageInfo) {
            $imageName = 'label_'.time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move($uploadDir, $imageName);

            return $imageName;
        }

        [$origWidth, $origHeight] = $imageInfo;

        if ($origWidth <= $maxWidth) {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        } else {
            $ratio = $maxWidth / $origWidth;
            $newWidth = $maxWidth;
            $newHeight = (int) ($origHeight * $ratio);
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        $imageName = 'label_'.time().'_'.uniqid().'.webp';
        $destPath = $uploadDir.'/'.$imageName;

        imagewebp($resized, $destPath, $quality);

        imagedestroy($source);
        imagedestroy($resized);

        return $imageName;
    }

    /**
     * Delete an image file from storage if it exists.
     */
    private function deleteImageFile(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $path = storage_path('uploads/food-labels/'.$filename);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    /**
     * Store a newly created food label in storage.
     */
    public function store(StoreFoodLabelRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $isPublishing = $validated['action'] === 'publish';
        $status = $isPublishing ? 'published' : 'draft';

        DB::beginTransaction();
        try {
            $slug = FoodLabel::generateUniqueSlug($validated['title'], $validated['menu_date']);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->processImage($request->file('image'));
            }

            $label = FoodLabel::create([
                'title' => $validated['title'],
                'slug' => $slug,
                'menu_date' => $validated['menu_date'],
                'description' => $validated['description'] ?? null,
                'image' => $imageName,
                'energy' => (float) ($validated['energy'] ?? 0),
                'protein' => (float) ($validated['protein'] ?? 0),
                'fat' => (float) ($validated['fat'] ?? 0),
                'carbohydrate' => (float) ($validated['carbohydrate'] ?? 0),
                'fiber' => (float) ($validated['fiber'] ?? 0),
                'consumption_limit_hours' => (float) ($validated['consumption_limit_hours'] ?? 4.0),
                'consumption_time_start' => $validated['consumption_time_start'] ?? null,
                'consumption_time_end' => $validated['consumption_time_end'] ?? null,
                'consumption_time_range' => $validated['consumption_time_range'] ?? null,
                'status' => $status,
                'published_at' => $isPublishing ? now() : null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Save menu items
            $menus = $request->input('menus', []);
            $order = 1;
            foreach ($menus as $menuName) {
                $trimmed = trim((string) $menuName);
                if ($trimmed !== '') {
                    FoodLabelMenu::create([
                        'food_label_id' => $label->id,
                        'name' => $trimmed,
                        'sort_order' => $order++,
                    ]);
                }
            }

            ActivityLog::record(
                'create_label',
                "Label makanan '{$label->title}' dibuat dengan status {$label->status_label}.",
                $label
            );

            DB::commit();

            $message = $isPublishing
                ? "Label makanan '{$label->title}' berhasil disimpan dan dipublikasikan!"
                : "Label makanan '{$label->title}' berhasil disimpan sebagai draft.";

            return redirect()->route('admin.labels.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan label: '.$e->getMessage());
        }
    }

    /**
     * Display the specified food label detail.
     */
    public function show(FoodLabel $label): View
    {
        $label->load(['menus', 'creator', 'updater']);

        return view('admin.labels.show', [
            'label' => $label,
        ]);
    }

    /**
     * Show the form for editing the specified food label.
     */
    public function edit(FoodLabel $label): View
    {
        $label->load('menus');

        return view('admin.labels.edit', [
            'label' => $label,
        ]);
    }

    /**
     * Update the specified food label in storage.
     */
    public function update(UpdateFoodLabelRequest $request, FoodLabel $label): RedirectResponse
    {
        $validated = $request->validated();
        $isPublishing = $validated['action'] === 'publish';
        $newStatus = $isPublishing ? 'published' : 'draft';

        DB::beginTransaction();
        try {
            // Update slug if title or date changed
            $slug = $label->slug;
            if ($label->title !== $validated['title'] || $label->menu_date->format('Y-m-d') !== $validated['menu_date']) {
                $slug = FoodLabel::generateUniqueSlug($validated['title'], $validated['menu_date'], $label->id);
            }

            $imageName = $label->image;

            if ($request->boolean('remove_image')) {
                $this->deleteImageFile($label->image);
                $imageName = null;
            }

            if ($request->hasFile('image')) {
                $this->deleteImageFile($label->image);
                $imageName = $this->processImage($request->file('image'));
            }

            $label->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'menu_date' => $validated['menu_date'],
                'description' => $validated['description'] ?? null,
                'image' => $imageName,
                'energy' => (float) ($validated['energy'] ?? $label->energy),
                'protein' => (float) ($validated['protein'] ?? $label->protein),
                'fat' => (float) ($validated['fat'] ?? $label->fat),
                'carbohydrate' => (float) ($validated['carbohydrate'] ?? $label->carbohydrate),
                'fiber' => (float) ($validated['fiber'] ?? $label->fiber),
                'consumption_limit_hours' => (float) ($validated['consumption_limit_hours'] ?? $label->consumption_limit_hours),
                'consumption_time_start' => array_key_exists('consumption_time_start', $validated) ? $validated['consumption_time_start'] : $label->consumption_time_start,
                'consumption_time_end' => array_key_exists('consumption_time_end', $validated) ? $validated['consumption_time_end'] : $label->consumption_time_end,
                'consumption_time_range' => array_key_exists('consumption_time_range', $validated) ? $validated['consumption_time_range'] : $label->consumption_time_range,
                'status' => $newStatus,
                'published_at' => $isPublishing ? ($label->published_at ?? now()) : null,
                'updated_by' => Auth::id(),
            ]);

            // Sync menu items
            $label->menus()->delete();
            $menus = $request->input('menus', []);
            $order = 1;
            foreach ($menus as $menuName) {
                $trimmed = trim((string) $menuName);
                if ($trimmed !== '') {
                    FoodLabelMenu::create([
                        'food_label_id' => $label->id,
                        'name' => $trimmed,
                        'sort_order' => $order++,
                    ]);
                }
            }

            ActivityLog::record(
                'update_label',
                "Label makanan '{$label->title}' diperbarui (Status: {$label->status_label}).",
                $label
            );

            DB::commit();

            $message = $isPublishing
                ? "Label makanan '{$label->title}' berhasil diperbarui dan dipublikasikan!"
                : "Label makanan '{$label->title}' berhasil diperbarui sebagai draft.";

            return redirect()->route('admin.labels.show', $label)->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui label: '.$e->getMessage());
        }
    }

    /**
     * Publish an existing food label immediately.
     */
    public function publish(FoodLabel $label): RedirectResponse
    {
        $label->load('menus');

        if ($label->menus->count() === 0) {
            return back()->with('error', 'Label tidak dapat dipublikasikan karena belum memiliki daftar menu makanan.');
        }

        if ($label->energy <= 0 || $label->consumption_limit_hours <= 0) {
            return back()->with('error', 'Label tidak dapat dipublikasikan karena nilai energi atau batas akhir konsumsi belum diisi dengan benar.');
        }

        $label->update([
            'status' => 'published',
            'published_at' => $label->published_at ?? now(),
            'updated_by' => Auth::id(),
        ]);

        ActivityLog::record(
            'publish_label',
            "Label makanan '{$label->title}' telah dipublikasikan untuk masyarakat.",
            $label
        );

        return back()->with('success', "Label makanan '{$label->title}' berhasil dipublikasikan!");
    }

    /**
     * Unpublish a food label (revert to draft).
     */
    public function unpublish(FoodLabel $label): RedirectResponse
    {
        $label->update([
            'status' => 'draft',
            'updated_by' => Auth::id(),
        ]);

        ActivityLog::record(
            'unpublish_label',
            "Publikasi label '{$label->title}' ditarik kembali menjadi draft.",
            $label
        );

        return back()->with('success', "Publikasi label '{$label->title}' berhasil ditarik menjadi draft.");
    }

    /**
     * Archive an existing food label.
     */
    public function archive(FoodLabel $label): RedirectResponse
    {
        $label->update([
            'status' => 'archived',
            'updated_by' => Auth::id(),
        ]);

        ActivityLog::record(
            'archive_label',
            "Label makanan '{$label->title}' diarsipkan dari daftar publik.",
            $label
        );

        return back()->with('success', "Label makanan '{$label->title}' berhasil diarsipkan.");
    }

    /**
     * Duplicate a food label to create a new draft copy.
     */
    public function duplicate(FoodLabel $label): RedirectResponse
    {
        $label->load('menus');

        DB::beginTransaction();
        try {
            $newTitle = $label->title.' (Salinan)';
            $newDate = Carbon::today()->format('Y-m-d');
            $newSlug = FoodLabel::generateUniqueSlug($newTitle, $newDate);

            $copiedImage = null;
            if ($label->image) {
                $src = storage_path('uploads/food-labels/'.$label->image);
                if (File::exists($src)) {
                    $copiedImage = 'label_'.time().'_'.uniqid().'.webp';
                    File::copy($src, storage_path('uploads/food-labels/'.$copiedImage));
                }
            }

            $newLabel = FoodLabel::create([
                'title' => $newTitle,
                'slug' => $newSlug,
                'menu_date' => $newDate,
                'description' => $label->description,
                'image' => $copiedImage,
                'energy' => $label->energy,
                'protein' => $label->protein,
                'fat' => $label->fat,
                'carbohydrate' => $label->carbohydrate,
                'fiber' => $label->fiber,
                'consumption_limit_hours' => $label->consumption_limit_hours,
                'consumption_time_start' => $label->consumption_time_start,
                'consumption_time_end' => $label->consumption_time_end,
                'consumption_time_range' => $label->consumption_time_range,
                'status' => 'draft',
                'published_at' => null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            foreach ($label->menus as $menu) {
                FoodLabelMenu::create([
                    'food_label_id' => $newLabel->id,
                    'name' => $menu->name,
                    'sort_order' => $menu->sort_order,
                ]);
            }

            ActivityLog::record(
                'duplicate_label',
                "Menduplikasi label '{$label->title}' menjadi draft baru '{$newLabel->title}'.",
                $newLabel
            );

            DB::commit();

            return redirect()->route('admin.labels.edit', $newLabel)
                ->with('success', 'Label berhasil disalin! Silakan periksa dan sesuaikan menu serta tanggal sebelum menerbitkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menduplikasi label makanan: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified food label from storage (soft delete).
     */
    public function destroy(FoodLabel $label): RedirectResponse
    {
        $title = $label->title;
        $label->delete();

        ActivityLog::record(
            'delete_label',
            "Label makanan '{$title}' dihapus (soft delete).",
            $label
        );

        return redirect()->route('admin.labels.index')
            ->with('success', "Label makanan '{$title}' berhasil dihapus.");
    }

    /**
     * Delete only the image of a food label.
     */
    public function deleteImage(FoodLabel $label): RedirectResponse
    {
        $this->deleteImageFile($label->image);
        $label->update(['image' => null]);

        ActivityLog::record(
            'delete_label_image',
            "Foto label makanan '{$label->title}' dihapus.",
            $label
        );

        return back()->with('success', 'Foto makanan berhasil dihapus.');
    }

    /**
     * Export food labels to CSV with formula injection defense.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = FoodLabel::with(['menus', 'creator']);

        if ($status !== 'all' && in_array($status, ['draft', 'scheduled', 'published', 'archived'])) {
            $query->where('status', $status);
        }
        if (! empty($search)) {
            $query->search($search);
        }

        $labels = $query->orderBy('menu_date', 'desc')->get();

        $filename = 'daftar-label-gizi-'.date('Ymd-His').'.csv';

        // Helper to prevent CSV formula injection
        $sanitizeCsv = function ($value): string {
            $value = (string) $value;
            if (isset($value[0]) && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"])) {
                return "'".$value;
            }

            return $value;
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($labels, $sanitizeCsv) {
            $output = fopen('php://output', 'w');
            // BOM for UTF-8 in Excel
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($output, [
                'ID',
                'Judul Label',
                'Tanggal Menu',
                'Status',
                'Energi (kkal)',
                'Protein (g)',
                'Lemak (g)',
                'Karbohidrat (g)',
                'Serat (g)',
                'Batas Konsumsi (Jam)',
                'Daftar Menu',
                'Dibuat Oleh',
                'Waktu Dibuat',
            ]);

            foreach ($labels as $label) {
                $menuList = $label->menus->pluck('name')->implode('; ');
                fputcsv($output, [
                    $label->id,
                    $sanitizeCsv($label->title),
                    $label->menu_date->format('Y-m-d'),
                    $sanitizeCsv($label->status_label),
                    $label->energy,
                    $label->protein,
                    $label->fat,
                    $label->carbohydrate,
                    $label->fiber,
                    $label->consumption_limit_hours,
                    $sanitizeCsv($menuList),
                    $sanitizeCsv($label->creator?->name ?? 'Sistem'),
                    $label->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }
}
