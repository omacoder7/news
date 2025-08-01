@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                <i class="fas fa-newspaper me-2"></i>Управление новостями
            </h2>
            <a href="{{ route('admin.news.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Добавить новость
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Автор</th>
                            <th>Фото</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <strong>{{ Str::limit($item->name, 50) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($item->description, 100) }}</small>
                                </td>
                                <td>{{ $item->author }}</td>
                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}" 
                                             alt="{{ $item->name }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 50px; max-height: 50px;">
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-image fa-2x"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('news.show', $item->id) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $item->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.news.delete', $item->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Удалить">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-newspaper fa-2x mb-2"></i>
                                    <p>Новости отсутствуют</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($news->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад к дашборду
        </a>
    </div>
</div>
@endsection 