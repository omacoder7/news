@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Регистрация
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

                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="login" class="form-label">
                                <i class="fas fa-user me-1"></i>Логин
                            </label>
                            <input type="text" class="form-control @error('login') is-invalid @enderror" 
                                   id="login" name="login" value="{{ old('login') }}" required>
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Пароль
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i>Повторить пароль
                            </label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus me-1"></i>Зарегистрироваться
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">Уже есть аккаунт? 
                            <a href="{{ route('auth.login.form') }}" class="text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i>Войти
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 