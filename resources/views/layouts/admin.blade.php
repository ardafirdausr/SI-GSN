@extends('layouts.app')
@section('app')
    <nav class="ui left vertical borderless sidebar menu">
        <div class="logo-pelindo">
            <img src="{{ asset('images/pelindo3.png') }}" alt="Pelindo 3 Logo">
        </div>
        <a class="item" href="{{ Route::currentRouteName() == 'web.jadwal.kedatangan' ? '#' : route('web.jadwal.kedatangan') }}">
            <div class="ui {{ Route::currentRouteName() == 'web.jadwal.kedatangan' ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="arrow right icon"></i>Jadwal Kedatangan
            </div>
        </a>
        <a class="item" href="{{ Route::currentRouteName() == 'web.jadwal.keberangkatan' ? '#' : route('web.jadwal.keberangkatan') }}">
            <div class="ui {{ Route::currentRouteName() == 'web.jadwal.keberangkatan' ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="arrow left icon"></i>Jadwal Keberangkatan
            </div>
        </a>
        <a class="item" href="{{ preg_match('/^web\.jadwal\.\w+$/im', Route::currentRouteName()) ? '#' : route('web.jadwal.index') }}">
            <div class="ui {{ preg_match('/^web\.jadwal\.\w+$/im', Route::currentRouteName()) ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="calendar alternate outline icon"></i>Master Jadwal
            </div>
        </a>
        <a class="item" href="{{ preg_match('/^web\.kapal\.\w+$/im', Route::currentRouteName()) ? '#' : route('web.kapal.index') }}">
            <div class="ui {{ preg_match('/^web\.kapal\.\w+$/im', Route::currentRouteName()) ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="ship icon"></i>Master Kapal
            </div>
        </a>
        <a class="item" href="{{ preg_match('/^web\.agen-pelayaran\.\w+$/im', Route::currentRouteName()) ? '#' : route('web.agen-pelayaran.index') }}">
            <div class="ui {{ preg_match('/^web\.agen-pelayaran\.\w+$/im', Route::currentRouteName()) ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="building outline icon"></i>Master Agen Pelayaran
            </div>
        </a>
        <a class="item" href="{{ preg_match('/^web\.user\.\w+$/im', Route::currentRouteName()) ? '#' : route('web.user.index') }}">
            <div class="ui {{ preg_match('/^web\.user\.\w+$/im', Route::currentRouteName()) ? 'primary' : 'deactive' }} fluid rounded button">
                <i class="user icon"></i>Master User
            </div>
        </a>
    </nav>
    <section class="pusher">
        <header class="ui borderless top menu" style="border-bottom: 0px">
            <div class="left menu">
                <a id="open-nav" class="item"><i class="icon content"></i></a>
                <h2 class="item ui header">@yield('title', 'Sistem Informasi Pelayanan Terminal GSN')</h2>
            </div>
            <div class="right menu">
                {{-- <div class="ui item" id="notification">
                    <i class="bell icon"></i>
                </div> --}}
                {{-- <div class="ui flowing popup bottom left transition hidden">
                    <div class="ui three column divided center aligned grid">
                    <div class="column">
                        <h4 class="ui header">Basic Plan</h4>
                        <p><b>2</b> projects, $10 a month</p>
                        <div class="ui button">Choose</div>
                    </div>
                    <div class="column">
                        <h4 class="ui header">Business Plan</h4>
                        <p><b>5</b> projects, $20 a month</p>
                        <div class="ui button">Choose</div>
                    </div>
                    <div class="column">
                        <h4 class="ui header">Premium Plan</h4>
                        <p><b>8</b> projects, $25 a month</p>
                        <div class="ui button">Choose</div>
                    </div>
                    </div>
                </div> --}}
                {{-- <div class="ui simple dropdown item">
                    <i class="bell icon"></i>
                    <div class="menu">
                        <a class="item"><i class="edit icon"></i> Edit Profile</a>
                        <a class="item"><i class="globe icon"></i> Choose Language</a>
                        <a class="item"><i class="settings icon"></i> Account Settings</a>
                    </div>
                </div> --}}
                <div class="ui simple dropdown item">
                    <span>
                        <img class="ui avatar image" src="/images/man.svg">
                        <span>{{ auth()->user()->name ?? 'Agus Yeay' }}</span>
                    </span>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{ route('web.user.profil') }}"><i class="user icon"></i>Profil</a>
                        <a class="item" href="{{ route('logout') }}"><i class="sign out icon"></i>Keluar</a>
                        {{-- <a class="item"><i class="edit icon"></i>Edit</a>
                        <a class="item"><i class="globe icon"></i>Language</a>
                        <a class="item"><i class="settings icon"></i>Settings</a> --}}
                    </div>
                </div>
            </div>
        </header>
        <section id="#content" class="container">
            @yield('content')
        </section>
    </section>
@endsection
@section('app-style')
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
    .rounded{
        border-radius: 8px !important;
        text-align: justify !important;
    }
    .rounded .icon{
        margin-right: 8px !important;
    }
	</style>
@endsection
@section('app-script')
	<script>
    $('#open-nav').on('click', function(){
        $('.ui.sidebar').sidebar('setting', 'dimPage', false)
                        .sidebar('setting', 'closeable', false)
                        .sidebar('setting', 'scrollLock', false)
                        .sidebar('toggle');
    })
    $('#notification').popup();
	</script>
@endsection