@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Редактировать новость
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-heading me-1"></i>Название
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $news->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Описание
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $news->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">
                                <i class="fas fa-user me-1"></i>Автор
                            </label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" value="{{ old('author', $news->author) }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">
                                <i class="fas fa-image me-1"></i>Фото
                            </label>
                            @if($news->photo)
                                <div class="mb-2">
                                    <img src="{{ asset($news->photo) }}" 
                                         alt="{{ $news->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px;">
                                    <p class="text-muted small">Текущее фото</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                   id="photo" name="photo" accept="image/*">
                            <div class="form-text">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>Сохранить изменения
                            </button>
                            <a href="{{ route('admin.news') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Назад
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 