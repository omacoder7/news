@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('news.index') }}" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>Главная
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('news.index') }}" class="text-decoration-none">Новости</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($newsItem->name, 50) }}</li>
                </ol>
            </nav>

            <article class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h2 mb-0">{{ $newsItem->name }}</h1>
                        <a href="{{ route('news.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Назад
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user text-primary me-2"></i>
                                <span class="fw-bold">Автор:</span>
                                <span class="ms-2">{{ $newsItem->author }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                {{-- @if($newsItem->photo)
                                    <img src="{{ asset($newsItem->photo) }}" class="img-fluid" style="max-height: 200px; object-fit: cover;">
                                @else --}}
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                {{-- @endif --}}
                                <span class="fw-bold">Дата публикации:</span>
                                <span class="ms-2">{{ $newsItem->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($newsItem->photo)
                    <div class="text-center mb-4">
                        <img src="{{ asset($newsItem->photo) }}" 
                            alt="{{ $newsItem->name }}" 
                            class="img-fluid rounded shadow-sm" 
                            style="max-height: 400px;">
                    </div>
                    @else
                    <div class="text-center mb-4">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="fas fa-newspaper fa-4x text-muted"></i>
                        </div>
                    </div>
                    @endif

                    <div class="news-content">
                        <p class="lead mb-4">{{ $newsItem->description }}</p>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Интересный факт:</strong> Эта новость была опубликована 
                            {{ $newsItem->created_at->diffForHumans() }} и уже привлекла внимание читателей.
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-thumbs-up me-1"></i>Нравится
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-share me-1"></i>Поделиться
                            </button>
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-comment me-1"></i>Комментировать
                            </button>
                        </div>
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-eye me-1"></i>Просмотров: {{ rand(100, 1000) }}
                            </small>
                        </div>
                    </div>
                </div>
            </article>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Похожие новости</h4>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-sm">
                        Все новости
                    </a>
                </div>
                <div class="row">
                    @php
                        $relatedNews = \App\Models\News::where('id', '!=', $newsItem->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();
                    @endphp
                    @foreach($relatedNews as $related)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($related->name, 60) }}</h6>
                                <p class="card-text small text-muted">
                                    {{ Str::limit($related->description, 80) }}
                                </p>
                                <a href="{{ route('news.show', $related->id) }}" class="btn btn-sm btn-outline-primary">
                                    Читать
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection