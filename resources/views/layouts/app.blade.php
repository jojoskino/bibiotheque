<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Bibliothèque') }}</title>
        
        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        
        <style>
            body {
                background: #f8f9fa;
            }
            .sidebar {
                min-height: 100vh;
                background: #23272b;
                color: #fff;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1030;
                width: 250px;
            }
            .sidebar .nav-link {
                color: #adb5bd;
                font-weight: 500;
            }
            .sidebar .nav-link.active, .sidebar .nav-link:hover {
                color: #fff;
                background: #495057;
            }
            .sidebar .nav-link i {
                margin-right: 8px;
            }
            .sidebar .sidebar-header {
                font-size: 1.5rem;
                font-weight: bold;
                padding: 1.5rem 1rem 1rem 1rem;
                color: #fff;
                border-bottom: 1px solid #343a40;
            }
            .sidebar-footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                padding: 1rem;
                font-size: 0.9rem;
                color: #adb5bd;
            }
            .flex-grow-1 {
                margin-left: 250px;
            }
            @media (max-width: 991.98px) {
                .sidebar {
                    min-height: auto;
                    position: static;
                    width: 100%;
                }
                .flex-grow-1 {
                    margin-left: 0;
                }
            }
        </style>
        
        @stack('styles')
    </head>
    <body>
        <div class="d-flex">
            <!-- Sidebar -->
            <nav class="sidebar d-flex flex-column flex-shrink-0 p-0">
                <div class="sidebar-header text-center mb-4">
                    <i class="fas fa-book-open me-2"></i>{{ config('app.name', 'Bibliothèque') }}
                </div>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('books.index') }}" class="nav-link {{ request()->is('books*') ? 'active' : '' }}">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('loans.index') }}" class="nav-link {{ request()->is('loans*') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding"></i> Emprunts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('authors.index') }}" class="nav-link {{ request()->is('authors*') ? 'active' : '' }}">
                            <i class="fas fa-user-edit"></i> Auteurs
                        </a>
                    </li>
                    @if(auth()->user()->is_admin)
                        <li>
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="mt-auto sidebar-footer">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-3 text-center">
                        <small>&copy; {{ date('Y') }} Bibliothèque</small>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <div class="flex-grow-1 p-4" style="min-height: 100vh;">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <main>
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
