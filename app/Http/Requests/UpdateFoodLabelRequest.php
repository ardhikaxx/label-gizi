<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodLabelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs before validation (trim strings).
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('menus') && is_array($this->input('menus'))) {
            $cleaned = array_map(function ($item) {
                return is_string($item) ? trim($item) : $item;
            }, $this->input('menus'));

            $this->merge(['menus' => $cleaned]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isPublishing = $this->input('action') === 'publish';

        $rules = [
            'action' => ['required', 'in:draft,publish'],
            'title' => ['required', 'string', 'max:255'],
            'menu_date' => ['required', 'date'],
            'recipient_group' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ];

        if ($isPublishing) {
            $rules['energy'] = ['required', 'numeric', 'min:0', 'max:10000'];
            $rules['protein'] = ['required', 'numeric', 'min:0', 'max:1000'];
            $rules['fat'] = ['required', 'numeric', 'min:0', 'max:1000'];
            $rules['carbohydrate'] = ['required', 'numeric', 'min:0', 'max:1000'];
            $rules['fiber'] = ['required', 'numeric', 'min:0', 'max:1000'];
            $rules['consumption_limit_hours'] = ['required', 'numeric', 'min:0.5', 'max:48'];
            $rules['menus'] = ['required', 'array', 'min:1'];
            $rules['menus.*'] = ['required', 'string', 'filled', 'max:255'];
        } else {
            $rules['energy'] = ['nullable', 'numeric', 'min:0', 'max:10000'];
            $rules['protein'] = ['nullable', 'numeric', 'min:0', 'max:1000'];
            $rules['fat'] = ['nullable', 'numeric', 'min:0', 'max:1000'];
            $rules['carbohydrate'] = ['nullable', 'numeric', 'min:0', 'max:1000'];
            $rules['fiber'] = ['nullable', 'numeric', 'min:0', 'max:1000'];
            $rules['consumption_limit_hours'] = ['nullable', 'numeric', 'min:0', 'max:48'];
            $rules['menus'] = ['nullable', 'array'];
            $rules['menus.*'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul atau nama label makanan wajib diisi.',
            'title.max' => 'Judul label tidak boleh melebihi 255 karakter.',
            'menu_date.required' => 'Tanggal menu wajib diisi.',
            'menu_date.date' => 'Format tanggal menu tidak valid.',
            'energy.required' => 'Kandungan energi (kkal) wajib diisi untuk publikasi.',
            'energy.numeric' => 'Nilai energi harus berupa angka.',
            'energy.min' => 'Nilai energi tidak boleh bernilai negatif.',
            'protein.required' => 'Kandungan protein (g) wajib diisi untuk publikasi.',
            'protein.numeric' => 'Nilai protein harus berupa angka.',
            'protein.min' => 'Nilai protein tidak boleh bernilai negatif.',
            'fat.required' => 'Kandungan lemak (g) wajib diisi untuk publikasi.',
            'fat.numeric' => 'Nilai lemak harus berupa angka.',
            'fat.min' => 'Nilai lemak tidak boleh bernilai negatif.',
            'carbohydrate.required' => 'Kandungan karbohidrat (g) wajib diisi untuk publikasi.',
            'carbohydrate.numeric' => 'Nilai karbohidrat harus berupa angka.',
            'carbohydrate.min' => 'Nilai karbohidrat tidak boleh bernilai negatif.',
            'fiber.required' => 'Kandungan serat (g) wajib diisi untuk publikasi.',
            'fiber.numeric' => 'Nilai serat harus berupa angka.',
            'fiber.min' => 'Nilai serat tidak boleh bernilai negatif.',
            'consumption_limit_hours.required' => 'Batas akhir konsumsi (jam setelah pengantaran) wajib diisi.',
            'consumption_limit_hours.min' => 'Batas akhir konsumsi harus lebih besar dari 0 jam.',
            'menus.required' => 'Minimal sertakan 1 menu makanan sebelum memublikasikan label.',
            'menus.min' => 'Minimal sertakan 1 menu makanan sebelum memublikasikan label.',
            'menus.*.required' => 'Nama item menu makanan tidak boleh kosong.',
            'menus.*.filled' => 'Nama item menu makanan tidak boleh hanya berisi spasi.',
            'image.image' => 'File foto makanan harus berupa berkas gambar.',
            'image.mimes' => 'Format foto makanan harus berupa JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran file foto makanan maksimal 5 MB.',
        ];
    }
}
