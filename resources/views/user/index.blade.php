@extends('layouts.admin')
@section('title')
Master User
@endsection
@section('content')
<div class="ui relaxed grid content-container">
	<div class="ten wide column">
		<div class="ui one column">
			<div class="ui two column grid">
				<div class="left aligned column">
					<h2 class="ui blue header clickable-header">
						<a href="{{ route('web.user.index') }}">Daftar User</a>
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
				class="ui raised {{$paginatedUser->hasMorePages() ? 'stacked' : '' }} segment selectable celled striped fixed collapsing table"
				>
				<thead>
					<tr>
						<th>No</th>
						<th>ID</th>
						<th colspan="2">Nama</th>
						<th>NIP</th>
						<th>Username</th>
						<th>Access Role</th>
						<th>Terakhir diubah</th>
						<th id="action-title" style="display: none;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@if(count($paginatedUser->items()) > 0)
					@foreach ($paginatedUser->items() as $idx => $user)
					<tr id="data-{{ $user->id }}">
						<td id="value-id" value="{{ $user->id }}">
								{{ (($paginatedUser->currentPage() - 1) * $paginatedUser->perPage() + ($idx + 1)) }}
						</td>
						<td id="value-id" value="{{ $user->id }}">
							{{ "usr-".$user->id }}
						</td>
						<td id="value-foto" value={{ $user->foto }} class="center aligned">
							<img
								src="{{ $user->foto ? asset($user->foto) : asset('images/base.png') }}"
								alt="{{ $user->nama }}"
								style="width: 100%; max-width: 150px">
						</td>
						<td id="value-nama" value="{{ $user->nama }}">
							{{ $user->nama }}
						</td>
						<td id="value-NIP" value="{{ $user->NIP }}">
							{{ $user->NIP }}
						</td>
						<td id="value-username" value="{{ $user->username }}">
							{{ $user->username }}
						</td>
						<td id="value-access_role" value="{{ $user->getRoleNames()->first() }}">
							{{ $user->getRoleNames()->first() }}
						</td>
						<td>
							<small>{{ date('d/m/Y', strtotime($user->updated_at)) }}</small>
							<small>{{ date('H:i T', strtotime($user->updated_at)) }}</small>
						</td>
						@if(auth()->user()->id == $user->id || $user->getRoleNames()->first() !== 'admin')
						<td class="action action-edit positive collapsing single line" style="display: none;">
							<div><i class="edit icon"></i>Edit</div>
						</td>
						@endif
						@if(auth()->user()->id != $user->id && $user->getRoleNames()->first() !== 'admin')
						<td class="action action-delete negative collapsing single line" style="display: none;">
							<div class="action-delete"><i class="trash icon"></i> Hapus</div>
						</td>
						@endif
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6" style="text-align:center"> Tidak ada jadwal hari ini</td>
					<tr>
						@endif
				</tbody>
			</table>
			@if($paginatedUser->total() > $paginatedUser->perPage())
			<div class="right aligned column">
				<div class="ui right floated pagination shadow menu">
					{{ $paginatedUser->links() }}
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
				@if(count($paginatedUser->items()) > 0)
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
						@if(count($topFiveUserLogs) > 0)
						@foreach ($topFiveUserLogs as $loguser)
						<tr>
							<td>
								{{ $loguser->aktivitas }}
							</td>
							<td>
								<div>{{ date('d/m/Y', strtotime($loguser->updated_at)) }}</div>
								<div>{{ date('H:i T', strtotime($loguser->updated_at)) }}</div>
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
			<form class="ui form error" id="create-form" method="POST" action="{{ route('web.user.store') }}" enctype="multipart/form-data">
				@csrf
				<h2 class="ui blue header" id="form-title">Tambah User</h2>
				<div class="ui raised segment">
					<div class="field error-deactiveable {{ $errors->has('nama') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="user icon"></i>
							<input type="text" id="create-nama" name="nama" placeholder="Masukkan Nama"
								value={{ old('nama') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('NIP') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="barcode icon"></i>
							<input type="text" id="create-NIP" name="NIP" placeholder="Masukkan NIP"
								value={{ old('NIP') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('username') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="id card icon"></i>
							<input type="text" id="create-username" name="username" placeholder="Masukkan Username"
								value={{ old('username') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('password') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<input type="password" id="create-password" name="password" placeholder="Masukkan Password" value="">
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('password_confirmation') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<input type="password" id="create-password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" value="">
						</div>
					</div>
					<div class="field error-deactiveable">
							<div class="ui fluid search selection dropdown" id="access_role-dropdown">
								<input type="hidden" name="access_role">
								<i class="dropdown icon"></i>
								<div class="default text">Pilih Access Role</div>
								<div class="menu">
									<div class="item" data-value="petugas terminal">Petugas Terminal</div>
									<div class="item" data-value="petugas agen">Petugas Agen</div>
									<div class="item" data-value="admin">Admin</div>
								</div>
							</div>
					</div>
					<div class="photo-field-container field error-deactiveable {{ $errors->has('foto') ? 'error' : '' }}">
						<label for="foto" >Foto User</label>
						<div class="ui left icon transparent input">
							<i class="photo icon"></i>
							<input type="file" id="create-foto" name="foto" placeholder="Pilih foto"
								value={{ old('foto') }}>
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
			<form class="ui error form" id="update-form" method="POST" action="{{ route('web.user.update', ['user' => ':user']) }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="PUT">
				<h2 class="ui green header" id="form-title">Edit User</h2>
				<div class="ui raised segment">
					<input type="hidden" name="id-update" value="{{ old('id-update') }}">
					<div class="field error-deactiveable {{ $errors->has('nama') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="user icon"></i>
							<input type="text" id="update-nama" name="nama" placeholder="Masukkan Nama"
								value={{ old('nama') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('NIP') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="barcode icon"></i>
							<input type="text" id="update-NIP" name="NIP" placeholder="Masukkan NIP"
								value={{ old('NIP') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('username') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="id card  icon"></i>
							<input type="text" id="update-username" name="username" placeholder="Masukkan Username"
								value={{ old('username') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('password') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<input type="password" id="update-password" name="password" placeholder="Masukkan Password" value="">
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('password_confirmation') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<input type="password" id="update-password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" value="">
						</div>
					</div>
					<div class="field error-deactiveable">
							<div class="ui fluid search selection dropdown" id='access_role-dropdown'>
								<input type="hidden" name="access_role">
								<i class="dropdown icon"></i>
								<div class="default text">Pilih Access Role</div>
								<div class="menu">
									<div class="item" data-value="petugas terminal">Petugas Terminal</div>
									<div class="item" data-value="petugas agen">Petugas Agen</div>
									<div class="item" data-value="admin">Admin</div>
								</div>
							</div>
					</div>
					<div class="photo-field-container field error-deactiveable {{ $errors->has('foto') ? 'error' : '' }}">
						<label for="foto" >Foto user</label>
						<div class="ui left icon transparent input">
							<i class="photo icon"></i>
							<input type="file" id="update-foto" name="foto" placeholder="Pilih foto"
								value={{ old('foto') }}>
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
			<form id="delete-form" method="POST" action="{{ route('web.user.destroy', ['user' => ':user']) }}">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
			</form>
		</div>
	</div>
</div>
<div class="ui mini basic modal delete-modal">
	<div class="ui icon header">
		<i class="trash icon"></i>
		User
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
		$('input[name=username]').val('');
		$('input[name=NIP]').val('');
		$('input[name=access_role]').val('');
		$('input[name=foto]').val('');
	}

	function activateLastUpdate(){
		var id = "{{old('id-update')}}";
		var selectedAccessRole = "{{old('access_role')}}";
		var selectedDataRow = $('#data-' + id);
		var imageSource = selectedDataRow.find('#value-foto').attr('value');
		selectedDataRow.addClass('active');
		var url = $('#update-form').attr('action');
		url = url.replace(':user', id);
		$('#update-form #access_role-dropdown').dropdown('set selected', selectedAccessRole);
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
		if(failedCreate){
			$('#create-button').click();
			var lastAccessRole = "{{old('access_role')}}";
			if(!!lastAccessRole) $('#create-form #access_role-dropdown').dropdown('set selected', lastAccessRole);
		}
		if(failedUpdate){
			$('#update-button').click();
			activateLastUpdate();
			toggleLogInformation(0);
			toggleUpdateForm(400);
			;
		}
	}

	// insert data to form
	function insertDataToUpdateForm(id, nama, username, NIP, access_role, foto) {
		var url = $('#update-form').attr('action');
		url = url.replace(':user', id);
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val(id);
		$('#update-form input[name=nama]').val(nama);
		$('#update-form input[name=username]').val(username);
		$('#update-form input[name=NIP]').val(NIP);
		$('#update-form #access_role-dropdown').dropdown('set selected', access_role);
		$('#update-form #img-upload-container').show();
		$('#update-form #img-upload').attr('src', foto);
		if("{{ auth()->user()->id }}" == id){
			$('#update-form #access_role-dropdown').addClass('disabled');
		}
		else{
			$('#update-form #access_role-dropdown').removeClass('disabled');
		}
	}

  // reset update form to its normal state
	function resetUpdateFormData(){
		var url = $('#update-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:user');
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val('');
		$('#update-form input[name=nama]').val('');
		$('#update-form input[name=username]').val('');
		$('#update-form input[name=NIP]').val('');
		$('#update-form input[name=access_role]').val('');
		$('#update-form #img-upload-container').hide();
		$('#update-form #img-upload').attr('src', '');
	}

	// reset create form to its normal state
	function resetCreateFormData(){
		$('#update-form input[name=nama]').val('');
		$('#update-form input[name=username]').val('');
		$('#update-form input[name=NIP]').val('');
		$('#update-form input[name=access_role]').val('');
		$('#update-form #img-upload-container').hide();
		$('#update-form #img-upload').attr('src', '');
	}

	function insertIdToDeleteForm(id){
		var url = $('#delete-form').attr('action');
		url = url.replace(':user', id);
		$('#delete-form').attr('action', url);
	}

	function removeIdFromDeletForm(){
		var url = $('#delete-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:user');
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
		var username = rowDataElement.find('#value-username').attr('value');
		var NIP = rowDataElement.find('#value-NIP').attr('value');
		var access_role = rowDataElement.find('#value-access_role').attr('value');
		var foto = rowDataElement.find('#value-foto').attr('value');
		deactiveAllUpdateableRow();
		setSelectedEditRowToActive(rowDataElement);
		resetUpdateFormData();
		insertDataToUpdateForm(id, nama, username, NIP, access_role, foto);
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

	$("#create-foto").on('change', function(){
		showPreview(this);
	});

	$('#update-foto').on('change', function(){
		showPreview(this);
	});

	$('.message .close').on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  });

	$('#access_role-dropdown').dropdown({ clearable: true })

	$('#create-form').form({
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
			NIP: {
				identifier  : 'NIP',
				rules: [
					{
						type   : 'empty',
						prompt : 'NIP tidak boleh kosong'
					},
					{
						type: 'maxLength[25]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 25'
					}
				]
			},
			username: {
				identifier  : 'username',
				rules: [
					{
						type   : 'empty',
						prompt : 'Username tidak boleh kosong'
					},
					{
						type: 'maxLength[25]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 25'
					}
				]
			},
			password: {
				identifier  : 'password',
				rules: [
					{
						type   : 'empty',
						prompt : 'Password tidak boleh kosong'
					}
				]
			},
			password_confirmation: {
				identifier  : 'password_confirmation',
				rules: [
					{
						type   : 'empty',
						prompt : 'Konfirmasi Password tidak boleh kosong'
					}
				]
			},
			access_role: {
				identifier  : 'access_role',
				rules: [
					{
						type   : 'empty',
						prompt : 'Access Role tidak boleh kosong'
					}
				]
			}
		}
  });

	$('#update-form').form({
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
			NIP: {
				identifier  : 'NIP',
				rules: [
					{
						type   : 'empty',
						prompt : 'NIP tidak boleh kosong'
					},
					{
						type: 'maxLength[25]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 25'
					}
				]
			},
			username: {
				identifier  : 'username',
				rules: [
					{
						type   : 'empty',
						prompt : 'Username tidak boleh kosong'
					},
					{
						type: 'maxLength[25]',
						prompt: 'Panjang maksimal karakter tidak boleh lebih dari 25'
					}
				]
			},
			access_role: {
				identifier  : 'access_role',
				rules: [
					{
						type   : 'empty',
						prompt : 'Access Role tidak boleh kosong'
					}
				]
			}
		}
  });

	$('#search-bar').search({
    minCharacters : 2,
		searchFullText: false,
    apiSettings   : {
			url: "{{ route('api.user.search') }}",
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

        // translate
        $.each(searchResult.data, function(index, item) {

          var maxResults = 5;
					// only show 5 top match
          if(index >= maxResults) return false;

          // add result to category
          response.results.push({
            title       : item.nama,
            description : item.access_role,
            url         : "{{ route('web.user.index') }}" + "?query=" + item.nama,
						// image: item.logo
          });
        });
        return response;
      },
    },
  });
</script>
@endsection
