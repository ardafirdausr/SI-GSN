@extends('layouts.app')
@section('title')
	Jadwal Keberangkatan
@endsection
@section('content')
	<div class="ui grid containers">
		<div class="row">
			<div class="column">
				<h2 class="ui header">{{ date("l, d-m-Y") }} </h2>
			</div>
		</div>
		<div class="row">
			<div class="left aligned thirteen wide column">
				<div class="ui one column grid">
					<div class="right aligned column">
						<table class="ui raised segment selectable celled striped fixed table">
							<thead>
								<tr>
									<th>Agen Pelayaran</th>
									<th>Kode Kapal</th>
									<th>Nama Kapal</th>
									<th>Tujuan</th>
									<th>Jam</th>
									<th>Status</th>
									<th id="action-title" style="display: none;">Action</th>
								</tr>
							</thead>
							<tbody>
								@if(count($jadwalCollection) > 0)
									@foreach ($jadwalCollection as $jadwal)
										<tr>
											<td class="nine wide">{{ $jadwal->kapal->agen_pelayaran->nama }}</td>
											<td class="one wide">{{ $jadwal->kapal->kode }}</td>
											<td class="one wide">{{ $jadwal->kapal->nama }}</td>
											<td class="one wide">{{ $jadwal->tujuan }}</td>
											<td class="one wide">{{ date("H : m", strtotime($jadwal->keberangkatan))." WIB" }}</td>
											<td class="{{ $jadwal->status == 'on schedule' ? 'positive' : 'negative' }}" >
												<i class="icon
													{{ $jadwal->status == 'on schedule' ? 'checkmark' : ''}}
													{{ $jadwal->status == 'delay' ? 'attention' : ''}}
													{{ $jadwal->status == 'cancel' ? 'close' : ''}}
												"></i>
												{{ $jadwal->status }}
											</td>
											<td class="action action-edit positive collapsing single line" style="display: none;">
												<div>
													<i class="edit icon"></i> Edit
												</div>
											</td>
											<td class="action action-delete negative collapsing single line" style="display: none;">
												<div class="action-delete">
													<i class="trash icon"></i> Hapus
												</div>
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="6" style="text-align:center"> Tidak ada jadwal hari ini</td>
									<tr>
								@endif
							</tbody>
						</table>
					</div>
					@if(count($jadwalCollection) > 0)
						<div class="right aligned column">
							<div class="ui right floated pagination shadow menu">
								<a class="icon item">
									<i class="left chevron icon"></i>
								</a>
								<a class="item">1</a>
								<a class="item">2</a>
								<a class="item">3</a>
								<a class="item">4</a>
								<a class="icon item">
									<i class="right chevron icon"></i>
								</a>
							</div>
						</div>
					@endif
				</div>
			</div>
			<div class="one wide column"></div>
			<div class="right aligned two wide column">
				@if(count($jadwalCollection) > 0)
					<div class="ui one column grid">
						<div class="column">
							<div class="ui green fluid shadow button action-button" id="show-update-button">
								<i class="edit icon"></i>
								Update
							</div>
						</div>
						<div class="column">
							<div class="ui red fluid shadow button action-button" id="show-delete-button">
								<i class="trash icon"></i>
								Hapus
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="ui basic modal delete-modal">
		<div class="ui icon header">
			<i class="trash icon"></i>
			Jadwal Pelayaran
		</div>
		<div class="content">
			<p>Anda yakin untuk menghapus item ini?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>No
			</div>
			<div class="ui green ok inverted button">
				<i class="checkmark icon"></i>Yes
			</div>
		</div>
	</div>
	<div class="ui modal update-modal">
		<h1 class="ui header">Buat Jadwal</h1>
		<div class="content">
			<div class="ui form">
				<div class="inline field">
					<label>Agen Pelayaran</label>
					<input type="text" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="inline field">
					<label>Kode kapal</label>
					<input type="text" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="inline field">
					<label>Nama Kapal</label>
					<input type="text" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="inline field">
					<label>Asal</label>
					<input type="text" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="inline field">
					<label>Keberangkatan</label>
					<input type="datetime" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="inline field">
					<label>Kedatangan</label>
					<input type="datetime" name="jakarta" placeholder="Jakarta">
				</div>
				<div class="ui submit button">Submit</div>
			</div>
		</div>
	</div>
	<style>
		.containers {
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
		$('#show-update-button').on('click', function(){
			var clickedElement = $(this);
			if(clickedElement.attr('isClicked') == 'true'){
				clickedElement.attr('isClicked', false);
				clickedElement.html("<i class='edit icon'></i> Update");
				$('.action-button').removeClass('disabled');
				$('#action-title').hide(200);
				$('.action-edit').hide(200);
			}
			else{
				clickedElement.attr('isClicked', true);
				clickedElement.html("<i class='checkmark icon'></i> Selesai");
				$('.action-button:not(#show-update-button)').addClass('disabled');
				$('#action-title').show(200);
				$('.action-edit').show(200);
			}
		});
		$('#show-delete-button').on('click', function(){
			var clickedElement = $(this);
			if(clickedElement.attr('isClicked') == 'true'){
				clickedElement.attr('isClicked', false);
				clickedElement.html("<i class='trash icon'></i> Hapus");
				$('.action-button').removeClass('disabled');
				$('#action-title').hide(200);
				$('.action-delete').hide(200);
			}
			else{
				clickedElement.attr('isClicked', true);
				clickedElement.html("<i class='checkmark icon'></i> Selesai");
				$('.action-button:not(#show-delete-button)').addClass('disabled');
				$('#action-title').show(200);
				$('.action-delete').show(200);
			}
		});
		$('#create-button').on('click', function(){
			alert();
			$('.ui.modal.create-modal').modal({
				closable  : true,
				// onDeny    : function(){
				// 	window.alert('Wait not yet!');
				// 	return false;
				// },
				onApprove : function() {

				}
			}).modal('show');
		});
		$('.action-delete').on('click', function(){
			$('.ui.basic.modal.delete-modal').modal({
					closable  : true,
					// onDeny    : function(){
					// 	window.alert('Wait not yet!');
					// 	return false;
					// },
					onApprove : function() {

					}
				}).modal('show');
		});
	</script>
@endsection