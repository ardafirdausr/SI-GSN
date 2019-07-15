@extends('layouts.admin')
@section('title')
Profil
@endsection
@section('content')
<div class="ui relaxed grid content-container">
	<div class="ui left floated center aligned four wide column">
		<div class="row">
			<div class="ui fluid image">
				<img src="{{ $user->foto ? asset($user->foto) : asset('images/base.png') }}"
					alt="{{ $user->nama }}"
					>
			</div>
		</div>
	</div>
	<div class="ui left floated left aligned five wide column">
		<form action="{{ route('web.user.update', ['user' => auth()->user()->id ]) }}" class="ui form">
			<div class="field">
				<label for="nama">Nama</label>
				<div class="ui transparent big left icon disabled input">
					<i class="user icon"></i>
					<input type="text" name="nama" value={{ $user->nama }}>
				</div>
			</div>
			<div class="field">
				<label for="NIP">NIP</label>
				<div class="ui transparent big left icon disabled input">
					<i class="barcode icon"></i>
					<input type="text" name="NIP" value={{ $user->NIP }}>
				</div>
			</div>
			<div class="field">
				<label for="username">Username</label>
				<div class="ui transparent big left icon disabled input">
					<i class="id card icon"></i>
					<input type="text" name="username" value={{ $user->username }}>
				</div>
			</div>
			<div class="field">
				<label for="access_role">Access Role</label>
				<div class="ui transparent big left icon disabled input">
					<i class="info circle icon"></i>
					<input type="text" name="access_role" value={{ Str::title($user->getRoleNames()->first()) }}>
				</div>
			</div>
		</form>
	</div>
	<div class="one wide column"></div>
	<div class="ui left floated left aligned five wide column segment" >
		<h2 class="ui header">Hak Akses {{ $user->getRoleNames()->first() }}</h2>
		<ul>
			@foreach ($user->getAllPermissions() as $permission)
				<li>{{ Str::title($permission->name) }}</li>
			@endforeach
		</ul>
	</div>
</div>
<style>
	.content-container {
		margin: 20px 40px !important;
	}
</style>
@endsection
