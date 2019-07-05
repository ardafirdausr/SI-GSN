@extends('layouts.admin')
@section('title')
	Master Jadwal Pelayaran
@endsection
@section('content')
	<div class="ui grid containers">
		<div class="row">
			<div class="left aligned ten wide column">
				<div class="ui one column grid">
					<div class="right aligned column">
						<table class="ui raised {{$paginatedKapal->hasMorePages() ? 'stacked' : '' }} segment selectable celled striped fixed table">
							<thead>
								<tr>
									<th>Kode</th>
									<th>Nama</th>
									<th colspan="2">Agen Pelayaran</th>
									<th id="action-title" style="display: none;">Action</th>
								</tr>
							</thead>
							<tbody>
								@if(count($paginatedKapal->items()) > 0)
									@foreach ($paginatedKapal->items() as $kapal)
										<tr class="selected">
											<td class="data-alamat">{{ $kapal->kode }}</td>
											<td class="data-nama">{{ $kapal->nama }}</td>
											<td>
												<img src="{{ asset($kapal->agen_pelayaran->logo) }}" alt="{{ $kapal->agen_pelayaran->nama }}" style="width:100%">
											</td>
											<td class="data-nama">{{ $kapal->agen_pelayaran->nama }}</td>
											<td class="action action-edit positive collapsing single line" style="display: none;">
												<div><i class="edit icon"></i>Edit</div>
											</td>
											<td class="action action-delete negative collapsing single line" style="display: none;">
												<div class="action-delete"><i class="trash icon"></i> Hapus</div>
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
					@if($paginatedKapal->total() > $paginatedKapal->perPage())
					<div class="right aligned column">
						<div class="ui right floated pagination shadow menu">
								{{ $paginatedKapal->links() }}
							</div>
						</div>
					@endif
				</div>
			</div>
			<div class="one wide six wide column">
				<div class="row">
					<div class="right aligned two wide column">
						@if(count($paginatedKapal->items()) > 0)
							<div class="ui three column grid">
								<div class="column">
									<div class="ui blue fluid shadow button action-button" id="create-button">
										<i class="plus icon"></i>
										Tambah
									</div>
								</div>
								<div class="column">
									<div class="ui green fluid shadow button action-button" id="update-button">
										<i class="edit icon"></i>
										Update
									</div>
								</div>
								<div class="column">
									<div class="ui red fluid shadow button action-button" id="delete-button">
										<i class="trash icon"></i>
										Hapus
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
				<div class="row" id="form-container" style="visibility: hidden; transition: visibility 200ms" >
					<form class="ui form" method="POST" action="{{ route('login') }}">
						@csrf
						<div class="ui raised segment">
								<div class="ui blue header" id="form-title"></div>
								<div class="field">
										<div class="ui left icon input">
												<i class="id card icon"></i>
												<input type="text" id="nama" name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
										</div>
								</div>
								<div class="field">
										<div class="ui left icon input">
												<i class="map icon"></i>
												<input type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat" value={{ old('alamat') }}>
										</div>
								</div>
								<div class="field">
										<div class="ui left icon input">
												<i class="phone icon"></i>
												<input type="text" id="telepon" name="telepon" placeholder="Masukkan Telepon" value={{ old('telepon') }}>
										</div>
								</div>
								<div class="field">
										<div class="ui left icon input">
												<i class="pin icon"></i>
												<input type="text" id="loket" name="loket" placeholder="Masukkan Loket" value={{ old('loket') }}>
										</div>
								</div>
								@if($errors->any())
										<div class="ui error message">
												<div class="header">Username atau Password Salah</div>
												<p>{{ $errors->first() }} </p>
										</div>
								@endif
								<button class="ui fluid large blue submit button">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="ui mini basic modal delete-modal">
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
		function removeFormValues(){
			$('#nama').val('');
			$('#alamat').val('');
			$('#telepon').val('');
			$('#loket').val('');
		}

		function insertSelectedEditButtonToForm(clickedParentElement){
			$('#nama').val(clickedParentElement.find('.data-nama').html());
			$('#alamat').val(clickedParentElement.find('.data-alamat').html());
			$('#telepon').val(clickedParentElement.find('.data-telepon').html());
			$('#loket').val(clickedParentElement.find('.data-loket').html());
		}

		function showForm(title){
			$('#form-container').css({
						opacity: 0,
						visibility: "visible"
					}).animate({
						opacity: 1
					}, 200);
			$('#form-title').html(title);
		}

		function hideForm(){
			$('#form-container').css({
						opacity: 1.0,
						visibility: "hidden"
				}).animate({
						opacity: 0
				}, 200);
			setTimeout(function(){ $('#form-title').html(''); }, 200);
		}

		$('#create-button').on('click', function(){
			var clickedElement = $(this);
			if(clickedElement.attr('isClicked') == 'true'){
				clickedElement.attr('isClicked', false);
				clickedElement.html("<i class='plus icon'></i> Tambah");
				$('.action-button').removeClass('disabled');
				hideForm();
			}
			else{
				clickedElement.attr('isClicked', true);
				clickedElement.html("<i class='times icon'></i> Batal");
				$('.action-button:not(#create-button)').addClass('disabled');
				removeFormValues();
				showForm('Tambah Agen Pelayaran');
			}
		});

		$('#update-button').on('click', function(){
			var clickedElement = $(this);
			if(clickedElement.attr('isClicked') == 'true'){
				clickedElement.attr('isClicked', false);
				clickedElement.html("<i class='edit icon'></i> Update");
				$('.action-button').removeClass('disabled');
				hideForm();
				$('#action-title').hide(200);
				$('.action-edit').hide(200);
			}
			else{
				clickedElement.attr('isClicked', true);
				clickedElement.html("<i class='times icon'></i> Batal");
				$('.action-button:not(#update-button)').addClass('disabled');
				$('#action-title').show(200);
				$('.action-edit').show(200);
			}
		});

		$('#delete-button').on('click', function(){
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
				clickedElement.html("<i class='times icon'></i> Batal");
				$('.action-button:not(#delete-button)').addClass('disabled');
				$('#action-title').show(200);
				$('.action-delete').show(200);
			}
		});

		$('.action-edit').on('click', function(){
			var clickedElement = $(this);
			insertSelectedEditButtonToForm(clickedElement.parent())
			if($('#form-container').css('visibility') == 'hidden') showForm('Edit Agen Pelayaran');
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