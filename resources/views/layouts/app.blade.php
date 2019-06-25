<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Informasi Pelayanan Terminal GSN') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="{{ asset('semantic.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('semantic.min.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="ui visible left vertical sidebar menu">
        <div class="logo-pelindo">
            <img src="{{ asset('images/pelindo3.png') }}" alt="Pelindo 3 Logo">
        </div>
        <a class="item">
            <div class="ui button">
                <i class="ship icon"></i>Jadwal Keberangkatan
            </div>
        </a>
        <a class="item">
            <div class="ui button">
                <i class="ship icon"></i>Jadwal Kedatangan
            </div>
        </a>
    </nav>
    <section class="pusher borderless">
        <header class="ui fixed top menu">
            {{-- style="border-radius: 0!important; border: 0; margin-left: 260px; -webkit-transition-duration: 0.5s;"> --}}
            <div class="left menu">
                    <a id="open-nav" class="item"><i class="icon content"></i></a>
                    <span class="item">Application</span>
            </div>
            <div class="right menu">
                    <div class="ui dropdown item">Language <i class="dropdown icon"></i>
                    <div class="menu">
                            <a class="item">English</a>
                            <a class="item">Russian</a>
                            <a class="item">Spanish</a>
                    </div>
                    </div>
                    <div class="item">
                            <div class="ui primary button">Sign Up</div>
                    </div>
            </div>
        </header>
    </section>
</body>
<style>
    header.ui.menu{
        border: none;
    }

    header.ui.menu *{
        border: none;
    }
    .logo-pelindo{
        padding: 30px 20px;
    }

    .logo-pelindo img{
        width: 100%;
    }
</style>
<script>
    $('#open-nav').on('click', function(){
        $('.ui.sidebar').sidebar('toggle push');
    })
</script>
</html>
