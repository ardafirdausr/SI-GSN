@extends('layouts.app')
@section('app')
	<div id="container">
		<div id="title-container">
			<div>
				<h1 class="ui header" style="color: white">
					<i class="ticket icon"></i>
					{{ $titleJadwal }}
				</h1>
			</div>
			<div >
				<h1 class="ui header" style="color: white">{{ date('l, d-m-y', strtotime($tanggal)) }}</h1>
			</div>
		</div>
		<div id="data-container">
			<table style="min-width: 100%;" class="ui raised segment fixed striped padded collapsing big blue inverted table">
				<thead>
					<tr>
						{{-- <th class="two wide">No. </th> --}}
						<th class="one wide"></th>
						<th class="three wide">Nama Kapal</th>
						<th class="five wide">Tujuan</th>
						<th class="two wide">Jam</th>
						<th class="three wide">Status</th>
						<th class="three wide">Loket</th>
					</tr>
				</thead>
				<tbody id="jadwal-body">
					@if(count($jadwalCollection) > 0)
						@foreach ($jadwalCollection as $idx => $jadwal)
						<tr id="data-{{ $jadwal->id }}" value="{{ $jadwal->id }}" style="display: none">
							{{-- <td class="two wide">
								{{ ($idx + 1).'. ' }}
							</td> --}}
							<td class="one wide data-container"></td>
							<td class="three wide data-container" id="value-kapal-nama" value="{{ $jadwal->kapal->nama }}">
								<div>
									{{ $jadwal->kapal->nama }}
								</div>
							</td>
							<td class="five wide data-container" id="value-kota" value="{{ $jadwal->kota }}">
								<div>
									{{ $jadwal->kota }}
								</div>
							</td>
							<td class="two wide data-container" id="value-waktu" value="{{ $jadwal->waktu }}">
								<div>{{ date('H : i T', strtotime($jadwal->waktu)) }}</div>
							</td>
							<td class="three wide data-container" id="value-status_tiket" value="{{ $jadwal->status_tiket }}">
								<div>
									{{ $jadwal->status_tiket }}
								</div>
							</td>
							<td class="three wide data-container">
								<div>
									{{ $jadwal->kapal->agen_pelayaran->loket }}
								</div>
							</td>
						</tr>
						@endforeach
					@elseif(count($jadwalCollection) < 1)
						<tr>
							<td colspan="7" style="text-align:center"> Tidak ada jadwal hari ini</td>
						<tr>
							<td></td>
					@endif
				</tbody>
			</table>
		</div>
		<div id="footer">
			<span>Pelabuhan Tanjung Perak</span>
			<span id="page"></span>
		</div>
	</div>
@endsection
@section('app-style')
	<style>
		body{
			background-color: #2185d0
		}
		#container{
			height: 100vh;
			widows: 100vw;
			overflow-y: hidden;
			overflow-x: hidden;
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
		}
		#title-container{
			padding: 20px 40px;
			display: flex;
			flex-direction: row;
			justify-content: space-between;
		}
		#data-container{
			width: 100%;
			flex-grow: 1;
		}
		table{
			overflow: hidden;
			height: 100%;
		}
		#footer{
			width: 100%;
			background-color: #1a71b2;
			padding: 10px 40px 10px;
			display: flex;
			flex-direction: row;
			justify-content: space-between;
		}

		#footer *{
			font-size: 20px;
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			color: white;
		}
	</style>
@endsection
@section('app-script')
	<script>
		var jadwal = {!! $jadwalCollection !!}
		var changeGroupDuration = 10000;
		var jadwalPerGroup = 8;
		var currentGroupedJadwalIndex = -1;
		var maxGroupedJadwalIndex = Math.ceil(jadwal.length / jadwalPerGroup) - 1;

		$(document).ready(function(){
			showJadwal();
			setInterval(function (){
				getNewestJadwal();
			}, changeGroupDuration);

			if(maxGroupedJadwalIndex > 0){
				setInterval(function(){
					showJadwal();
				}, changeGroupDuration);
			}
		});

		function *generateGroupedJadwal(){
			while(true){
				currentGroupedJadwalIndex = currentGroupedJadwalIndex == maxGroupedJadwalIndex ? 0 : (currentGroupedJadwalIndex + 1);
				var startGroupedJadwalIndex = (currentGroupedJadwalIndex * jadwalPerGroup);
				var endGroupedJadwalIndex = startGroupedJadwalIndex + jadwalPerGroup;
				yield jadwal.slice(startGroupedJadwalIndex,  endGroupedJadwalIndex);
			}
		}

		function showJadwal(){
			// $('#jadwal-body td.data-container > div').css('height', '100%');
			// $('#jadwal-body td.data-container').css('height', 'calc(100%/' + jadwalPerGroup +')');
			toggleJadwalView();
			setTimeout(function(){
				$('#jadwal-body tr.showed').removeClass('showed');
				var groupedJadwalGenerator = generateGroupedJadwal();
				var groupedJadwal = groupedJadwalGenerator.next().value;
				$("#page").html((currentGroupedJadwalIndex + 1) + ' / ' + (maxGroupedJadwalIndex + 1));
				groupedJadwal.forEach(function(jadwal){
					$('#data-' + jadwal.id).addClass('showed');
				});
				toggleJadwalView();
			}, 725);
		}

		function toggleJadwalView(){
			$('#jadwal-body tr.showed').transition({
				animation: 'flip vertical',
				interval: 50,
				duration: 500
			});
		}

		function renderJadwal(newJadwal){
			var isDataLengthChanged = jadwal.length !== newJadwal.length;
			jadwal = newJadwal;
			var maxGroupedJadwalIndex = Math.ceil(jadwal.length / jadwalPerGroup) - 1;
			jadwal.forEach(function(elem){
				$('#data-' + elem.id + " #value-status_tiket").attr('value', elem.status_tiket);
				$('#data-' + elem.id + " #value-status_tiket").html(elem.status_tiket);
			});
			if(isDataLengthChanged){
				$('#jadwal-body tr').transition({
					animation: 'flip vertical',
					interval: 50,
					duration: 500,
				});
				setTimeout(() => {
					$('#jadwal-body').html('');
					jadwal.forEach(function(elem){
						var waktu =  new Date(elem.waktu);
						var hour = ("0" + waktu.getHours()).slice(-2);
						var minute = ("0" + waktu.getTime()).slice(-2);
						$('#jadwal-body').append(
							"<tr id='data-" + elem.id + "' value='" + elem.id + "' style='display: none'>" +
								"<td class='one wide'></td>" +
								"<td class='three wide' id='value-kapal-nama' value='" + elem.kapal.nama + "'>" + elem.kapal.nama + "</td>" +
								"<td class='five wide' id='value-kota' value='" + elem.kota + "'>" + elem.kota + "</td>" +
								"<td class='three wide' id='value-waktu' value='" + elem.waktu + "'>" + hour + " : " + minute + "WIB" + "</td>" +
								"<td class='three wide' id='value-status_tiket' value='" + elem.status_tiket + "'>" + elem.status_tiket + "</td>" +
							"</tr>"
						);
					});
					showJadwal();
				}, 725);
			}
		}

		function getNewestJadwal(){
			$.ajax({
				url: "{{ preg_match('/^web\.jadwal\.kedatangan.+$/im', Route::currentRouteName()) ? route('api.jadwal.kedatangan') : route('api.jadwal.keberangkatan') }}",
				method: 'GET',
				data: { size: 0 },
				success: function(response){
					renderJadwal(response.data);
				}
			})
		}

	</script>
@endsection