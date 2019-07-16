@extends('layouts.app')
<div class="ui grid">
	<div class="two column row">
		<div class="left floated column">
			<h1 class="ui h1">{{ $titleJadwal }}</h1>
		</div>
		<div class="left floated column right aligned">
			<h1 class="ui h1">{{ date('l, d-m-y', strtotime($tanggal)) }}</h1>
		</div>
	</div>
</div>
<table style="min-width: 100%"
	class="ui raised {{$paginatedJadwal->hasMorePages() ? 'stacked' : '' }}
		segment striped padded collapsing big blue inverted table"
	>
	<thead>
		<tr>
			<th>Nama Kapal</th>
			<th>{{ preg_match('/^web\.jadwal\.kedatangan.+$/im', Route::currentRouteName()) ? 'Asal' : 'Tujuan'}}</th>
			<th>Jam</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@if(count($paginatedJadwal->items()) > 0)
		@foreach ($paginatedJadwal->items() as $jadwal)
		<tr id="data-{{ $jadwal->id }}" value="{{ $jadwal->id }}">
			<td id="value-kapal-nama" value="{{ $jadwal->kapal->nama }}">
				{{ $jadwal->kapal->nama }}
			</td>
			<td id="value-kota" value="{{ $jadwal->kota }}">
				{{ $jadwal->kota }}
			</td>
			<td id="value-waktu" value="{{ $jadwal->waktu }}">
				<div>{{ date('H:i T', strtotime($jadwal->waktu)) }}</div>
			</td>
			<td id="value-status_tiket" value="{{ $jadwal->status_tiket }}">
				{{ $jadwal->status_tiket }}
			</td>
		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="7" style="text-align:center"> Tidak ada jadwal hari ini</td>
		<tr>
			@endif
	</tbody>
</table>