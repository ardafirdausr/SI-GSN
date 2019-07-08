@extends('layouts.admin')
@section('title')
Master Jadwal Pelayaran
@endsection
@section('content')
<div class="ui grid containers">
	<div class="nine wide column">
		<div class="ui one column">
			<div class="ui two column grid">
				<div class="left aligned column">
					<h2 class="ui header">Daftar Agen Pelayaran</h2>
				</div>
				<div class="right aligned column">
					<div class="ui icon small input">
						<input type="text" placeholder="Cari.....">
						<i class="search link icon"></i>
					</div>
				</div>
			</div>
			<table class="ui raised {{$paginatedAgenPelayaran->hasMorePages() ? 'stacked' : '' }} segment selectable celled striped fixed collapsing table">
				<thead>
					<tr>
						<th>ID</th>
						<th colspan="2">Agen</th>
						<th>Alamat</th>
						<th>Telepon</th>
						<th>Loket</th>
						<th>Terakhir diubah</th>
						<th id="action-title" style="display: none;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@if(count($paginatedAgenPelayaran->items()) > 0)
					@foreach ($paginatedAgenPelayaran->items() as $agenPelayaran)
					<tr>
						<td id="data-id" value="{{ $agenPelayaran->id }}">
							{{ $agenPelayaran->id }}
						</td>
						<td class="center aligned">
							<img src="{{ $agenPelayaran->logo }}" alt="{{ $agenPelayaran->nama }}" id="data-gambar">
						</td>
						<td id="data-nama" value="{{ $agenPelayaran->nama }}">
							{{ $agenPelayaran->nama }}
						</td>
						<td id="data-alamat" value="{{ $agenPelayaran->alamat }}">
							{{ $agenPelayaran->alamat }}
						</td>
						<td id="data-telepon" value="{{ $agenPelayaran->telepon }}">
							{{ $agenPelayaran->telepon }}
						</td>
						<td id="data-loket" value="{{ $agenPelayaran->loket }}">
							{{ $agenPelayaran->loket }}
						</td>
						<td>
							<div>{{ date('d/m/Y', strtotime($agenPelayaran->updated_at)) }}</div>
							<div>{{ date('H:m T', strtotime($agenPelayaran->updated_at)) }}</div>
						</td>
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
			@if($paginatedAgenPelayaran->total() > $paginatedAgenPelayaran->perPage())
			<div class="right aligned column">
				<div class="ui right floated pagination shadow menu">
					{{ $paginatedAgenPelayaran->links() }}
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="one wide column"></div>
	<div class="six wide column">
		<div class="row">
			<h2 class="ui header">Aksi</h2>
			<div class="right aligned two wide column">
				@if(count($paginatedAgenPelayaran->items()) > 0)
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
		<div class="row changeable-segment" id="log-container">
			<div class="ui one column">
				<h2 class="ui header">Log Perubahan</h2>
				<table class="ui raised segment selectable celled striped fixed small collapsing table">
					<thead>
						<tr>
							<th>Aktivitas</th>
							<th>Tanggal</th>
						</tr>
					</thead>
					<tbody>
						@if(count($topFiveAgenPelayaranLogs) > 0)
						@foreach ($topFiveAgenPelayaranLogs as $logAgenPelayaran)
						<tr>
							<td>
								{{ $logAgenPelayaran->aktivitas }}
							</td>
							<td>
								<div>{{ date('d/m/Y', strtotime($logAgenPelayaran->updated_at)) }}</div>
								<div>{{ date('H:m T', strtotime($logAgenPelayaran->updated_at)) }}</div>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="6" style="text-align:center"> Tidak ada log</td>
						<tr>
							@endif
					</tbody>
					<tfoot>
						<tr class="center aligned">
							<th colspan="2">
								<a href="">Lihat aktivitas lengkap</a>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="row changeable-segment" id="create-form-container">
			<form class="ui form" id="create-form" method="POST" action="{{ route('web.agen-pelayaran.store') }}">
				@csrf
				<h2 class="ui blue header" id="form-title">Tambah Agen Pelayaran</h2>
				<div class="ui raised segment">
					<div class="field">
						<div class="ui left icon input">
							<i class="id card icon"></i>
							<input type="text" name="nama" placeholder="Masukkan Nama"
								value="{{ old('nama') }}">
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="map icon"></i>
							<input type="text" name="alamat" placeholder="Masukkan Alamat"
								value={{ old('alamat') }}>
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="phone icon"></i>
							<input type="text" name="telepon" placeholder="Masukkan Telepon"
								value={{ old('telepon') }}>
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="pin icon"></i>
							<input type="text" name="loket" placeholder="Masukkan Loket"
								value={{ old('loket') }}>
						</div>
					</div>
					<div class="field">
						<label  id="filename" class="custom-file-label" for="validatedCustomFile"></label>
						<div class="ui left icon transparent input">
							<i class="photo icon"></i>
							<input type="file" name="logo"id="logo" placeholder="Pilih logo agen"
								value={{ old('loket') }}>
						</div>
						<div id="img-upload-container" class="my-md-3">
							<img id='img-upload'/>
						</div>
						<small id="photoHelpBlock" class="form-text text-muted">
							Foto yang yang dipilih berformat .jpg, .png, .jpeg, dengan kapasitas kurang dari 2MB
						</small>
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
		<div class="row changeable-segment" id="update-form-container">
			<form class="ui form" id="update-form" method="POST" action="{{ route('web.agen-pelayaran.update', ['agenPelayaran' => ':agenPelayaran']) }}">
				@csrf
				<input type="hidden" name="_method" value="PUT">
				<h2 class="ui green header" id="form-title">Edit Agen Pelayaran</h2>
				<div class="ui raised segment">
					<div class="field">
						<div class="ui left icon input">
							<i class="id card icon"></i>
							<input type="text" name="nama" placeholder="Masukkan Nama"
								value="{{ old('nama') }}">
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="map icon"></i>
							<input type="text" name="alamat" placeholder="Masukkan Alamat"
								value={{ old('alamat') }}>
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="phone icon"></i>
							<input type="text" name="telepon" placeholder="Masukkan Telepon"
								value={{ old('telepon') }}>
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="pin icon"></i>
							<input type="text" name="loket" placeholder="Masukkan Loket"
								value={{ old('loket') }}>
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
		box-shadow: 0 2px 4px 0 rgba(34, 36, 38, .12), 0 2px 10px 0 rgba(34, 36, 38, .15) !important;
	}

	.action {
		cursor: pointer;
	}

	#data-gambar{
		width: 100%;
		max-width: 150px;
	}

	.changeable-segment{
		margin-top: 30px;
	}

	#create-form-container, #update-form-container{
		display: none;
	}

	#img-upload-container{
		width: 100%;
		padding: 5px;
		display: flex;
		justify-content: center;
		align-items: center;
		border: 1px solid #eaeaea;
		min-height: 200px;
	}
	#img-upload{
		width: 100%;
		object-fit: cover;
	}
	#logo{
		text-overflow: ellipsis;
		overflow: hidden;
	}
</style>
<script>
	// insert data to form
	function insertDataToUpdateForm(id, nama, alamat, telepon, loket) {
		var url = $('#update-form').attr('action');
		url = url.replace(':agenPelayaran', id);
		$('#update-form').attr('action', url);
		$('#update-form input[name=nama]').val(nama);
		$('#update-form input[name=alamat]').val(alamat);
		$('#update-form input[name=telepon]').val(telepon);
		$('#update-form input[name=loket]').val(loket);
	}

  // reset update form to its normal state
	function resetUpdateFormData(){
		var url = $('#update-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:agenPelayaran');
		$('#update-form').attr('action', url);
		$('#update-form input[name=nama]').val('');
		$('#update-form input[name=alamat]').val('');
		$('#update-form input[name=telepon]').val('');
		$('#update-form input[name=loket]').val('');
	}

	function setSelectedEditRowToActive(clickedElement){
		clickedElement.addClass('active');
	}

	function deactiveAllUpdateableRow(clickedElement){
		$('.action-edit' ).parent().removeClass('active');
	}

  // show action button
	function showRowActionButton(type){
		$('#action-title').show(200);
		$('.action-' + type).show(200);
	}

	// hide action button
	function hideRowActionButton(type){
		$('#action-title').hide(200);
		$('.action-' + type).hide(200);
	}

	// set clickedElement<Button> to clicked state
	function setButtonToClickedState(clickedElement, text, icon){
		clickedElement.attr('isClicked', true);
		clickedElement.html("<i class='" + (icon || 'times') + " icon'></i>" + (text || 'Batal') );
		$('.action-button:not(#' + clickedElement.attr('id') + ')').addClass('disabled');
	}

  // set clickedElement<Button> to unclicked state
	function setButtonToUnclickedState(clickedElement, text, icon){
		clickedElement.attr('isClicked', false);
		clickedElement.html("<i class='" + icon + " icon'></i>" + text );
		$('.action-button').removeClass('disabled');
	}

  // toggle element that show log information
	function toggleLogInformation(timeout){
		setTimeout(function(){
			$('#log-container').transition('fade up');
		}, timeout || 0);
	}

  // toggle create form
	function toggleCreateForm(timeout){
		setTimeout(function(){
			$('#create-form-container').transition('fade up');
		}, timeout || 0);
	}

  // toogle update form
	function toggleUpdateForm(timeout){
		setTimeout(function(){
			$('#update-form-container').transition('fade up');
		}, timeout || 0);
	}

	// listener for clicked
	$('#create-button').on('click', function(){
		var clickedElement = $(this);
		if (clickedElement.attr('isClicked') == 'true') {
			setButtonToUnclickedState(clickedElement, 'Tambah', 'plus')
			toggleLogInformation(400);
			toggleCreateForm(0)
		} else {
			setButtonToClickedState(clickedElement, 'Batal', 'times');
			toggleLogInformation(0);
			toggleCreateForm(400)
		}
	});

	// show update action button
	$('#update-button').on('click', function () {
		var clickedElement = $(this);
		if (clickedElement.attr('isClicked') == 'true') {
			setButtonToUnclickedState(clickedElement, 'Update', 'edit');
			hideRowActionButton('edit');
			deactiveAllUpdateableRow();
			if($('#update-form-container').css('display') != 'none'){
				toggleUpdateForm(0);
				toggleLogInformation(400);
			}
		} else {
			setButtonToClickedState(clickedElement, 'Batal', 'times');
			showRowActionButton('edit');
		}
	});

	// show delete action button
	$('#delete-button').on('click', function () {
		var clickedElement = $(this);
		if (clickedElement.attr('isClicked') == 'true') {
			setButtonToUnclickedState(clickedElement, 'Hapus', 'trash');
			hideRowActionButton('delete');
		} else {
			setButtonToClickedState(clickedElement, 'Batal', 'times');
			showRowActionButton('delete');
		}
	});

  // listener for selected row data to insert it values to edit form
	$('.action-edit').on('click', function () {
		var clickedElement = $(this);
		var rowDataElement = clickedElement.parent();
		var id = rowDataElement.find('#data-id').attr('value');
		var nama = rowDataElement.find('#data-nama').attr('value');
		var alamat = rowDataElement.find('#data-alamat').attr('value');
		var telepon = rowDataElement.find('#data-telepon').attr('value');
		var loket = rowDataElement.find('#data-loket').attr('value');
		deactiveAllUpdateableRow();
		setSelectedEditRowToActive(rowDataElement);
		resetUpdateFormData();
		insertDataToUpdateForm(id, nama, alamat, telepon, loket);
		if ($('#update-form-container').css('display') == 'none'){
			toggleLogInformation(0);
			toggleUpdateForm(400);
		}
	});

  // listenser for selected row to show delete modal
	$('.action-delete').on('click', function () {
		$('.ui.basic.modal.delete-modal').modal({
			closable: true,
			onApprove: function () {
			}
		}).modal('show');
	});

	function showPreview(input) {
		console.log(input.files);
		if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
						$('#filename').text(input.files[0].name);
						$('#img-upload').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
		}
		else{
			$('#filename').text("");
			$('#img-upload').attr('src', "");
		}
	}

	$("#logo").on('change', function(){
			showPreview(this);
	});
</script>
@endsection
