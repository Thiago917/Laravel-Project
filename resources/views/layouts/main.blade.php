<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src='/js/index.js'></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- ion-icons styles import --}}

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>
<body>
    <header>
        <nav class="nav">
            <a href='/'><img src="/assets/logo.jpg" alt="" class="logo-marca img-fluid"></a>
            <ul class="navbar-ul">
                <li class="nav_item">
                    <a href="/" class="nav-link">Eventos</a>
                </li>
                <li class="nav_item">
                    <a href="/events/create" class="nav-link">Criar Eventos</a>
                </li>
                
                @auth
                <li class="nav_item">
                    <a href="/dashboard" class="nav-link">Meus Eventos</a>
                </li>
                <li class="nav_item">
                    <form action="/logout" method="POST">
                    @csrf
                    <a href="/logout" class="nav-link" onclick="event.preventDefault();this.closest('form').submit();">Sair</a>
                    </form>
                </li>
                    
                @endauth

                @guest
                    
                    <li class="nav_item">
                        <a href="/login" class="nav-link">Entrar</a>
                    </li>
                    <li class="nav_item">
                        <a href="/register" class="nav-link">Cadastrar-se</a>
                    </li>
                
                @endguest
            </ul>
        </nav>
    </header>

    <main>
        <div class="container-fluid">
            <div class="row">
                @if (session('msg'))
                    <p class="msg">{{ session('msg') }}</p>                    
                @endif
                @yield('content')
            </div>
        </div>
    </main>
    <footer>HDC Events &copy; 2021</footer>
</body>
</html>