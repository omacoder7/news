
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('news.index') }}">
                <i class="fas fa-newspaper me-2"></i>Новостной портал
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.index') }}">
                            <i class="fas fa-home me-1"></i>Главная
                        </a>
                    </li>
                    @if(session('user_id'))
                        @php
                            $user = \App\Models\User::find(session('user_id'));
                        @endphp
                        @if($user && $user->isAdminOrContentManager())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>Админ панель
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">
                                <i class="fas fa-user me-1"></i>{{ session('user_login') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login.form') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Логин
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
