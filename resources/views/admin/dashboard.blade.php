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
        <div class="col-12">
            <h2 class="mb-0">
                <i class="fas fa-tachometer-alt me-2"></i>Админ панель
            </h2>
        </div>
    </div>

    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Всего пользователей
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Всего новостей
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_news'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Администраторы
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_admins'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Контент-менеджеры
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_content_managers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Топ 5 новостей -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-newspaper me-2"></i>Топ 5 новостей
                    </h6>
                    <a href="{{ route('admin.news') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-list me-1"></i>Все новости
                    </a>
                </div>
                <div class="card-body">
                    @if($topNews->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topNews as $news)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $news->name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ $news->author }} | 
                                            <i class="fas fa-calendar me-1"></i>{{ $news->created_at->format('d.m.Y H:i') }}
                                        </small>
                                    </div>
                                    <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Новости отсутствуют</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Топ авторов -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-users me-2"></i>Топ авторов
                    </h6>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-list me-1"></i>Все пользователи
                    </a>
                </div>
                <div class="card-body">
                    @if($topAuthors->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topAuthors as $author)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $author->author }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-newspaper me-1"></i>{{ $author->news_count }} новостей
                                        </small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $author->news_count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Авторы отсутствуют</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-bolt me-2"></i>Быстрые действия
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Добавить пользователя
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Добавить новость
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-info w-100">
                                <i class="fas fa-users me-2"></i>Управление пользователями
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.news') }}" class="btn btn-warning w-100">
                                <i class="fas fa-newspaper me-2"></i>Управление новостями
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
</style>
@endsection 