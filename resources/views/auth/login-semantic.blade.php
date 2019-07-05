@extends('layouts.app')
@section('app')
<div class="ui middle aligned center aligned grid">
    <div class="left aligned column">
        <h2 class="ui blue image header" id="title-container">
            <img src="/images/pelindo3.png" class="fluid large image" id="logo-pelindo">
            <div class="content" id="title-login">Login</div>
        </h2>
        <form class="ui large error form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="ui stacked raised segment">
                <div class="field">
                    <label for="username">Username</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="Masukkan Username" value="{{ old('username') }}">
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="Masukkan Password" value={{ old('password') }}>
                    </div>
                </div>
                <div class="inline field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label>Ingat Saya</label>
                    </div>
                </div>
                @if($errors->any())
                    <div class="ui error message">
                        <div class="header">Username atau Password Salah</div>
                        <p>{{ $errors->first() }} </p>
                    </div>
                @endif
                <button class="ui fluid large blue submit button">Login</button>
            </div>
        </form>
        {{-- <div class="ui message">
					New to us? <a href="#">Sign Up</a>
			</div> --}}
    </div>
</div>
@endsection

@section('app-style')
<style>
    #title-container{
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
    }
    #logo-pelindo{
        width: 200px !important;
        margin-right: 5px;
    }
    #title-login{
        font-size: 40px !important;
        text-anchor: end;
    }

    body {
        background-color: #DADADA;
    }

    body>.grid {
        height: 100%;
    }

    .image {
        margin-top: -100px;
    }

    .column {
        max-width: 450px;
    }

</style>
@endsection
