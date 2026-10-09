@extends('layouts.public')

@section('title', 'Daftar Label Makanan Bergizi')
@section('meta_description', 'Katalog lengkap label makanan bergizi gratis yang telah diterbitkan. Telusuri menu makanan, informasi zat gizi, dan batas akhir konsumsi.')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small text-uppercase">Katalog Publik</span>
        <h1 class="fw-bold text-dark mt-2 mb-2">Daftar Label Makanan Bergizi</h1>
        <p class="text-muted small mx-auto" style="max-width: 600px;">
            Seluruh label makanan yang telah diverifikasi dan dipublikasikan resmi oleh pengelola pangan untuk transparansi informasi masyarakat.
        </p>

        <!-- Search & Filter Card -->
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-2 bg-light">
                    <form action="{{ route('public.labels') }}" method="GET" class="row g-2 align-items-center p-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-success"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" name="search" class="form-control border-0 ps-1" placeholder="Cari menu, judul, atau lauk..." value="{{ $search }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                                <input type="date" name="date" class="form-control border-0 ps-1" value="{{ $date }}" title="Filter Tanggal Menu">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex gap-1">
                            <button type="submit" class="btn btn-success flex-grow-1 rounded-pill py-2 fw-medium shadow-sm">
                                Filter
                            </button>
                            @if(!empty($search) || !empty($date))
                                <a href="{{ route('public.labels') }}" class="btn btn-outline-secondary rounded-pill py-2" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cards Catalog Section -->
<section class="py-5 bg-light">
    <div class="container">
        @if($labels->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                <i class="fa-solid fa-magnifying-glass fs-1 text-muted mb-3 opacity-25"></i>
                <h5 class="fw-bold text-dark mb-1">Tidak Ada Label Makanan yang Cocok</h5>
                <p class="text-muted small mb-3">
                    @if(!empty($search) || !empty($date))
                        Tidak ditemukan label makanan dengan kata kunci atau tanggal yang dipilih.
                    @else
                        Belum ada label makanan yang dipublikasikan saat ini.
                    @endif
                </p>
                @if(!empty($search) || !empty($date))
                    <div>
                        <a href="{{ route('public.labels') }}" class="btn btn-success btn-sm rounded-pill px-4">
                            Tampilkan Semua Label
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="row g-4 mb-4">
                @foreach($labels as $label)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 nutrition-card p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-light text-success border fw-semibold">
                                        <i class="fa-regular fa-calendar me-1"></i> {{ $label->menu_date->isoFormat('D MMMM Y') }}
                                    </span>
                                    @if($label->recipient_group)
                                        <span class="badge bg-light text-secondary border small">{{ $label->recipient_group }}</span>
                                    @endif
                                </div>

                                <h5 class="fw-bold text-dark mb-3">
                                    <a href="{{ route('public.labels.show', $label->slug) }}" class="text-decoration-none text-dark hover-success">
                                        {{ $label->title }}
                                    </a>
                                </h5>

                                <!-- Menu Items preview -->
                                <div class="mb-3">
                                    <small class="text-muted fw-bold d-block mb-1 text-uppercase" style="font-size: 0.72rem;">Daftar Menu:</small>
                                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-1">
                                        @foreach($label->menus->take(4) as $m)
                                            <li class="text-truncate text-secondary">
                                                <i class="fa-solid fa-circle-check text-success small me-1"></i> {{ $m->name }}
                                            </li>
                                        @endforeach
                                        @if($label->menus->count() > 4)
                                            <li class="text-muted small fst-italic">+{{ $label->menus->count() - 4 }} menu lainnya</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="pt-3 border-top mt-3">
                                <!-- Nutrition Summary Pills -->
                                <div class="d-flex justify-content-between text-center gap-1 mb-3">
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val text-success">{{ number_format($label->energy, 0, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Kkal</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($label->protein, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Prot (g)</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($label->fat, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Lemak (g)</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($label->carbohydrate, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Karbo (g)</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <span class="small text-muted" title="{{ $label->formatted_consumption_limit }}">
                                        <i class="fa-regular fa-clock text-warning me-1"></i> Maks. {{ $label->consumption_limit_hours }} jam
                                    </span>
                                    <a href="{{ route('public.labels.show', $label->slug) }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                        Lihat Detail <i class="fa-solid fa-arrow-right small ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Server-Side Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $labels->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>
@endsection
