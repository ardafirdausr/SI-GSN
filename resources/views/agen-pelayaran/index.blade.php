@extends('layouts.admin')
@section('title')
Master Agen Pelayaran
@endsection
@section('content')
<div class="ui grid content-container">
	<div class="ten wide column">
		<div class="ui one column">
			<div class="ui two column grid">
				<div class="left aligned column">
					<h2 class="ui blue header clickable-header">
						<a href="{{ route('web.agen-pelayaran.index') }}">Daftar Agen Pelayaran</a>
					</h2>
				</div>
				<div class="right aligned column">
					<div class="ui fluid search" id="search-bar">
						<div class="ui icon fluid input">
							<input class="prompt" type="text" placeholder="Cari..." id="search">
							<i class="search icon"></i>
						</div>
						<div class="results"></div>
					</div>
				</div>
			</div>
			<table style="min-width: 100%"
				class="ui raised {{$paginatedAgenPelayaran->hasMorePages() ? 'stacked' : '' }}
					segment selectable celled striped fixed padded collapsing small table"
				>
				<thead>
					<tr>
						<th>No</th>
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
					@foreach ($paginatedAgenPelayaran->items() as $idx => $agenPelayaran)
					<tr id="data-{{ $agenPelayaran->id }}">
						<td>
							{{ (($paginatedAgenPelayaran->currentPage() - 1) * $paginatedAgenPelayaran->perPage() + ($idx + 1)) }}
						</td>
						<td id="value-id" value="{{ $agenPelayaran->id }}">
							{{ "agn-".$agenPelayaran->id }}
						</td>
						<td id="value-logo" value={{ $agenPelayaran->logo }} class="center aligned">
							<img
								src="{{ $agenPelayaran->logo ? asset($agenPelayaran->logo) : asset('images/base.png') }}"
								alt="{{ $agenPelayaran->nama }}" style="width: 100%; max-width: 150px">
						</td>
						<td id="value-nama" value="{{ $agenPelayaran->nama }}">
							{{ $agenPelayaran->nama }}
						</td>
						<td id="value-alamat" value="{{ $agenPelayaran->alamat }}">
							{{ $agenPelayaran->alamat }}
						</td>
						<td id="value-telepon" value="{{ $agenPelayaran->telepon }}">
							{{ $agenPelayaran->telepon }}
						</td>
						<td id="value-loket" value="{{ $agenPelayaran->loket }}">
							{{ $agenPelayaran->loket }}
						</td>
						<td>
							<div><small>{{ date('d/m/Y', strtotime($agenPelayaran->updated_at)) }}</small></div>
							<div><small>{{ date('H:m T', strtotime($agenPelayaran->updated_at)) }}</small></div>
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
						<td colspan="7" style="text-align:center"> Tidak ada jadwal hari ini</td>
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
	{{-- <div class="one wide column"></div> --}}
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
				<table class="ui raised segment selectable celled striped fixed small collapsing definition table" style="width: 100%">
					<thead class="full-width">
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
							<td colspan="2" style="text-align:center"> Tidak ada log</td>
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
			<div class="ui one column changeable-segment error-removeable" >
				@if(session()->has('errorMessage'))
				<div class="ui icon tiny error message" id="errorMessage">
						<i class="close icon"></i>
					<i class="notched x icon"></i>
					<div class="content">
						<div class="header">
							{{ session('errorMessage') }}
						</div>
						{{-- <p>We're fetching that content for you.</p> --}}
					</div>
				</div>
				@endif
				@if(session()->has('successMessage'))
				<div class="ui icon tiny success message" id="successMessage">
					<i class="close icon"></i>
					<i class="notched check icon"></i>
					<div class="content">
						<div class="header">
							{{ session('successMessage') }}
						</div>
						{{-- <p>We're fetching that content for you.</p> --}}
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="row changeable-segment" id="create-form-container" style="display: none">
			<form class="ui form error" id="create-form" method="POST" action="{{ route('web.agen-pelayaran.store') }}" enctype="multipart/form-data">
				@csrf
				<h2 class="ui blue header" id="form-title">Tambah Agen Pelayaran</h2>
				<div class="ui raised segment">
					<div class="field error-deactiveable {{ $errors->has('nama') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="id card icon"></i>
							<input type="text" id="create-nama" name="nama" placeholder="Masukkan Nama"
								value={{ old('nama') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('alamat') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="map icon"></i>
							<input type="text" id="create-alamat" name="alamat" placeholder="Masukkan Alamat"
								value={{ old('alamat') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('telepon') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="phone icon"></i>
							<input type="text" id="create-telepon" name="telepon" placeholder="Masukkan Telepon"
								value={{ old('telepon') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('loket') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="pin icon"></i>
							<input type="text" id="create-loket" name="loket" placeholder="Masukkan Loket"
								value={{ old('loket') }}>
							</div>
					</div>
					<div class="photo-field-container field error-deactiveable {{ $errors->has('logo') ? 'error' : '' }}">
						<label for="logo" >Logo Agen Pelayaran</label>
						<div class="ui left icon transparent input">
							<i class="photo icon"></i>
							<input type="file" id="create-logo" name="logo" placeholder="Pilih logo agen"
								value={{ old('logo') }}>
							</div>
						<div id="img-upload-container" class="my-md-3" style="display: none">
							<img id='img-upload'/>
						</div>
						<small id="photoHelpBlock" class="form-text text-muted">
							Foto yang yang dipilih berformat .jpg, .png, .jpeg, dengan kapasitas kurang dari 2MB
						</small>
					</div>
					@if($errors->any())
					<div class="ui error message error-removeable">
						<div class="header">{{ session('errorMessage') }}</div>
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error}}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<input type="submit" name="create-form" value="Simpan" class="ui fluid large blue submit button">
				</div>
			</form>
		</div>
		<div class="row changeable-segment" id="update-form-container" style="display: none">
			<form class="ui error form" id="update-form" method="POST" action="{{ route('web.agen-pelayaran.update', ['agenPelayaran' => ':agenPelayaran']) }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="PUT">
				<h2 class="ui green header" id="form-title">Edit Agen Pelayaran</h2>
				<div class="ui raised segment">
					<input type="hidden" name="id-update" value="{{ old('id-update') }}">
					<div class="field error-deactiveable {{ $errors->has('nama') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="id card icon"></i>
							<input type="text" id="update-nama" name="nama" placeholder="Masukkan Nama"
								value="{{ old('nama') }}">
						</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('alamat') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="map icon"></i>
							<input type="text" id="update-alamat" name="alamat" placeholder="Masukkan Alamat"
								value={{ old('alamat') }}>
						</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('telepon') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="phone icon"></i>
							<input type="text" id="update-telepon" name="telepon" placeholder="Masukkan Telepon"
								value={{ old('telepon') }}>
						</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('loket') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="pin icon"></i>
							<input type="text" id="update-loket" name="loket" placeholder="Masukkan Loket"
								value={{ old('loket') }}>
						</div>
					</div>
					<div class="photo-field-container field error-deactiveable {{ $errors->has('logo') ? 'error' : '' }}">
						<label for="logo" >Logo Agen Pelayaran</label>
						<div class="ui left icon transparent input">
							<i class="photo icon"></i>
							<input type="file" id="update-logo" name="logo" placeholder="Pilih logo agen"
								value={{ old('logo') }}>
						</div>
						<div id="img-upload-container" class="my-md-3" style="display: none">
							<img id='img-upload'/>
						</div>
						<small id="photoHelpBlock" class="form-text text-muted">
							Foto yang yang dipilih berformat .jpg, .png, .jpeg, dengan kapasitas kurang dari 2MB
						</small>
					</div>
					@if($errors->any())
					<div class="ui error message error-removeable">
						<div class="header">{{ session('errorMessage') }}</div>
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error}}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<input type="submit" name="update-form" value="Simpan" class="ui fluid large green submit button">
				</div>
			</form>
		</div>
		<div id="delete-form-container" style="display: none">
			<form id="delete-form" method="POST" action="{{ route('web.agen-pelayaran.destroy', ['agenPelayaran' => ':agenPelayaran']) }}">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
			</form>
		</div>
	</div>
</div>
<div class="ui mini basic modal delete-modal">
	<div class="ui icon header">
		<i class="trash icon"></i>
		Agen Pelayaran
	</div>
	<div class="content">
		<p>Anda yakin untuk menghapus item ini?</p>
	</div>
	<div class="actions">
		<div class="ui red basic cancel inverted button">
			<i class="remove icon"></i>Tidak
		</div>
		<div class="ui green ok inverted button">
			<i class="checkmark icon"></i>Ya
		</div>
	</div>
</div>
<style>
	.content-container {
		margin: 20px 40px !important;
	}

	.shadow {
		box-shadow: 0 2px 4px 0 rgba(34, 36, 38, .12), 0 2px 10px 0 rgba(34, 36, 38, .15) !important;
	}

	.action {
		cursor: pointer;
	}

	.changeable-segment{
		margin-top: 30px;
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

	.photo-field-container > *{
		margin: 10px auto;
	}

	.clickable-header *{
		color: rgba(0, 0, 0, 0.87);
	}

	.clickable-header *:hover{
		color: #2185d0;
		text-decoration: underline;
	}

</style>
<script>

	$(document).ready(function(){
		setLastState();
		setTimeout(function() {
			hideAllDismissableMessage();
		}, 3000);
	});

	function hideAllDismissableMessage(){
		$('.message .close').closest('.message')
      									.transition('fade')
	}

	function removeOldValues(){
		$('input[name=id-update]').val('');
		$('input[name=nama]').val('');
		$('input[name=alamat]').val('');
		$('input[name=telepon]').val('');
		$('input[name=loket]').val('');
	}

	function activateLastUpdate(){
		var id = "{{old('id-update')}}";
		var selectedDataRow = $('#data-' + id);
		var imageSource = selectedDataRow.find('#value-logo').attr('value');
		selectedDataRow.addClass('active');
		var url = $('#update-form').attr('action');
		url = url.replace(':agenPelayaran', id);
		$('#update-form').attr('action', url);
		$('#update-form #img-upload-container').show();
		$('#update-form #img-upload').attr('src', imageSource);
	}

	function mapQueryToObject(){
		var queries = {};
		if(document.location.search){
			var querieStrings = document.location.search.substr(1).split('&');
			$.each(querieStrings, function(c,q){
				var i = q.split('=');
				queries[i[0].toString()] = decodeURIComponent(i[1].toString());
			});
		}
		return queries;
	}

	function setLastState(){
		var queryString = mapQueryToObject(location.search);
		$('#search').val(queryString.query);
		var failedCreate = {{ session()->has('failedCreate') ? 'true' : 'false' }};
		var failedUpdate = {{ session()->has('failedUpdate') ? 'true' : 'false' }};
		if(failedCreate) $('#create-button').click();
		if(failedUpdate){
			$('#update-button').click();
			activateLastUpdate();
			toggleLogInformation(0);
			toggleUpdateForm(400);
			;
		}
	}

	// insert data to form
	function insertDataToUpdateForm(id, nama, alamat, telepon, loket, logo) {
		var url = $('#update-form').attr('action');
		url = url.replace(':agenPelayaran', id);
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val(id);
		$('#update-form input[name=nama]').val(nama);
		$('#update-form input[name=alamat]').val(alamat);
		$('#update-form input[name=telepon]').val(telepon);
		$('#update-form input[name=loket]').val(loket);
		$('#update-form #img-upload-container').show();
		$('#update-form #img-upload').attr('src', logo);
	}

  // reset update form to its normal state
	function resetUpdateFormData(){
		var url = $('#update-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:agenPelayaran');
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val('');
		$('#update-form input[name=nama]').val('');
		$('#update-form input[name=alamat]').val('');
		$('#update-form input[name=telepon]').val('');
		$('#update-form input[name=loket]').val('');
		$('#update-form #img-upload-container').hide();
		$('#update-form #img-upload').attr('src', '');
	}

	// reset create form to its normal state
	function resetCreateFormData(){
		$('#create-form input[name=nama]').val('');
		$('#create-form input[name=alamat]').val('');
		$('#create-form input[name=telepon]').val('');
		$('#create-form input[name=loket]').val('');
		$('#create-form #img-upload-container').hide();
		$('#create-form #img-upload').attr('src', '');
	}

	function insertIdToDeleteForm(id){
		var url = $('#delete-form').attr('action');
		url = url.replace(':agenPelayaran', id);
		$('#delete-form').attr('action', url);
	}

	function removeIdFromDeletForm(){
		var url = $('#delete-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:agenPelayaran');
	}

	function resetAllForm(){
		resetCreateFormData();
		resetUpdateFormData();
		removeIdFromDeletForm()
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

	function removeAllErrorMessage(){
		$('.error-deactiveable').removeClass('error');
		$('.error-removeable').hide();
	}

	// listener for clicked
	$('#create-button').on('click', function(){
		var clickedElement = $(this);
		if (clickedElement.attr('isClicked') == 'true') {
			setButtonToUnclickedState(clickedElement, 'Tambah', 'plus');
			removeOldValues();
			resetAllForm();
			removeAllErrorMessage();
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
			removeOldValues();
			resetAllForm();
			removeAllErrorMessage();
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
			removeOldValues();;
			removeAllErrorMessage();
			resetAllForm();
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
		var id = rowDataElement.find('#value-id').attr('value');
		var nama = rowDataElement.find('#value-nama').attr('value');
		var alamat = rowDataElement.find('#value-alamat').attr('value');
		var telepon = rowDataElement.find('#value-telepon').attr('value');
		var loket = rowDataElement.find('#value-loket').attr('value');
		var logo = rowDataElement.find('#value-logo').attr('value');
		deactiveAllUpdateableRow();
		setSelectedEditRowToActive(rowDataElement);
		resetUpdateFormData();
		insertDataToUpdateForm(id, nama, alamat, telepon, loket, logo);
		if ($('#update-form-container').css('display') == 'none'){
			toggleLogInformation(0);
			toggleUpdateForm(400);
		}
	});

  // listenser for selected row to show delete modal
	$('.action-delete').on('click', function () {
		var clickedElement = $(this);
		var rowDataElement = clickedElement.parent();
		var id = rowDataElement.find('#value-id').attr('value');
		$('.ui.basic.modal.delete-modal').modal({
			closable: true,
			onApprove: function () {
				insertIdToDeleteForm(id);
				$('#delete-form').submit();
			}
		}).modal('show');
	});

	function showPreview(input) {
		var selectedInput = $(input);
		var fieldContainer = selectedInput.closest('div.photo-field-container');
		var photoContainer = fieldContainer.find('#img-upload-container');
		var photo = fieldContainer.find('#img-upload');

		if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					photoContainer.show();
					photo.attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
		}
		else{
			photoContainer.hide();
			photo.attr('src', "");
		}
	}

	$("#create-logo").on('change', function(){
		showPreview(this);
	});

	$('#update-logo').on('change', function(){
		showPreview(this);
	});

	$('#create-form,#update-form').form({
		on: 'blur',
		inline: true,
		fields: {
			nama: {
				identifier  : 'nama',
				rules: [
					{
						type: 'empty',
						prompt: 'Nama tidak boleh kosong'
					},
					{
						type: 'maxLength[50]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 50'
					}
				]
			},
			alamat: {
				identifier  : 'alamat',
				rules: [
					{
						type   : 'empty',
						prompt : 'Alamat tidak boleh kosong'
					},
					{
						type: 'maxLength[100]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 100'
					}
				]
			},
			telepon: {
				identifier  : 'telepon',
				rules: [
					{
						type   : 'empty',
						prompt : 'Telepon tidak boleh kosong'
					},
					{
						type: 'maxLength[20]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 20'
					}
				]
			},
			loket: {
				identifier  : 'loket',
				rules: [
					{
						type   : 'empty',
						prompt : 'Loket tidak boleh kosong'
					}
				]
			}
		}
  });

	$('.message .close').on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  });

	$('#search-bar').search({
    minCharacters : 2,
		searchFullText: false,
    apiSettings   : {
			url: "{{ route('api.agen-pelayaran.search') }}",
			method: 'GET',
			beforeSend: function(settings) {
				settings.data = {
					'query': $('#search').val()
				};
				return settings;
			},
      onResponse: function(searchResult) {
        var response = {
            results : []
        };
					console.log('keyword : ', $('#search').val());
					console.log('results : ', searchResult);
        // translate
        $.each(searchResult.data, function(index, item) {

          var maxResults = 5;
					// only show 5 top match
          if(index >= maxResults) return false;

          // add result to category
          response.results.push({
            title       : item.nama,
            description : item.alamat,
            url         : "{{ route('web.agen-pelayaran.index') }}" + "?query=" + item.nama,
						// image: item.logo
          });
        });
        return response;
      },
    },
  });
</script>
@endsection
