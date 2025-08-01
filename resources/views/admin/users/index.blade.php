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
                <i class="fas fa-users me-2"></i>Управление пользователями
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Добавить пользователя
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
                            <th>Логин</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->login }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-user-shield me-1"></i>Администратор
                                        </span>
                                    @elseif($user->role === 'content_manager')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-user-edit me-1"></i>Контент-менеджер
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user me-1"></i>Пользователь
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id != session('user_id'))
                                            <form action="{{ route('admin.users.delete', $user->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled title="Нельзя удалить самого себя">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <p>Пользователи отсутствуют</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
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