@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Личный кабинет
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <i class="fas fa-user-circle fa-5x text-muted mb-3"></i>
                                <h5 class="card-title">{{ session('user_login') }}</h5>
                                <p class="text-muted">Добро пожаловать в личный кабинет!</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-3">
                                <a href="{{ route('profile.change-password.form') }}" class="btn btn-warning">
                                    <i class="fas fa-key me-2"></i>Изменить пароль
                                </a>
                                <a href="{{ route('profile.add-news.form') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Добавить новость
                                </a>
                                <a href="{{ route('auth.logout') }}" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 