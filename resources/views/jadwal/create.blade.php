@extends('layouts.app')
@section('title')
	Tambah Jadwal Pelayaran
@endsection
@section('content')
	<div class="ui container">
		<div class="ui form">
			<div class="inline fields">
				<label for="tipe">Pilih pelayaran : </label>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="tipe" value="keberangkatan" tabindex="0" class="hidden">
						<label>Keberangkatan</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="tipe" value="kedatangan" tabindex="0" class="hidden">
						<label>Kedatangan</label>
					</div>
				</div>
			</div>
			<div class="fields">
				<div class="seven wide field">
						<label class="three wide column">Tanggal Keberangkatan</label>
						<input class="four wide column" type="date" placeholder="Full Name">
				</div>
				<div class="one wide field"></div>
				<div class="seven wide field">
						<label class="three wide column">Waktu Keberangkatan</label>
						<input class="four wide column" type="time" placeholder="Full Name">
				</div>
			</div>
			<div class="fields">
				<div class="seven wide field">
						<label class="three wide column">Tanggal Kedatangan</label>
						<input class="four wide column" type="date" placeholder="Full Name">
				</div>
				<div class="one wide field"></div>
				<div class="seven wide field">
						<label class="three wide column">Tanggal Kedatangan</label>
						<input class="four wide column" type="time" placeholder="Full Name">
				</div>
			</div>
			<div class="fields">
				<div class="fifteen wide field">
					<label class="three wide column">Agen Pelayaran</label>
					<select class="ui search dropdown">
						<option value="">Pilih Masakapai</option>
						@foreach ($agenPelayaranCollection as $agenPelayaran)
						<option value="{{ $agenPelayaran->id }}"> {{ $agenPelayaran->nama }} </option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="fields">
				<div class="fifteen wide field">
					<label class="three wide column">Kapal</label>
					<select class="ui search dropdown" id="id_kapal" disabled>
						<option value="">Pilih Kapal</option>
						<option value="AF">Afghanistan</option>
						<option value="AX">Åland Islands</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<style>
		.custom-container {
			margin: 20px 40px !important;
		}
		.shadow {
			box-shadow: 0 2px 4px 0 rgba(34,36,38,.12), 0 2px 10px 0 rgba(34,36,38,.15) !important;
		}
		.action {
			cursor: pointer;
		}
	</style>
	<script>
		$('select.dropdown').dropdown();
		function render(){
			$('.loading').removeClass('active');
		}
		render();
	</script>
@endsection