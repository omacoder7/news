@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row" id="news-container">
        @foreach($news as $item)
        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    @if($item->photo)
                        <img src="{{ asset($item->photo) }}" class="img-fluid" style="max-height: 200px; object-fit: cover;" alt="{{ $item->name }}">
                    @else
                        <i class="fas fa-newspaper fa-3x text-muted"></i>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-3">{{ $item->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">
                        {{ Str::limit($item->description, 120) }}
                    </p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>{{ $item->author }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $item->created_at->format('d.m.Y') }}
                            </small>
                        </div>
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-1"></i>Читать далее
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($news->hasPages())
        <div class="col-12">
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Навигация по страницам">
                    {{ $news->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
        @endif 
    </div>  
@endsection

