@extends('layouts.petugas-agen')
@section('title')
{{ $titleJadwal }}
@endsection
@section('content')
<div class="ui relaxed grid content-container">
	<div class="ten wide column">
		<div class="ui grid">
			{{-- <div class="row">
				<div class="right floated right aligned five wide column">
					<h1 class="ui header">Pencarian</h1>
				</div>
				<div class="right floated right aligned eleven wide column">
					<form class="ui form" action="{{ route(Route::currentRouteName()) }}" id="search-form">
						<div class="two fields">
							<div class="field">
								<div class="ui input">
									<input type="date" name="tanggal" style="height: 38px !important" placeholder="hari/jam/tahun"
									value="{{ $tanggal }}">
								</div>
							</div>
							<div class="field">
								<div class="ui search selection dropdown" id="query-dropdown">
									<input type="hidden" name="query">
									<i class="dropdown icon"></i>
									<div class="default text">Nama Kapal</div>
								</div>
							</div>
							<button class="ui right labeled icon primary button">
								Cari
								<i class="search icon"></i>
							</button>
						</form>
					</div>
				</div>
			</div> --}}
			<div class="row">
				<div class="left floated ten wide column">
					<h2 class="ui blue header clickable-header">
						<a href="#">{{ date('l, d-m-Y', strtotime($tanggal)) }}</a>
					</h2>
				</div>
				<div class="right floated aligned three wide column">
					<a class="ui blue fluid shadow button action-button"
						href="{{ route(Route::currentRouteName().'-list') }}"
						>
						<i class="eye icon"></i>View
					</a>
				</div>
			</div>
			<div class="row">
				<div class="column">
					<table style="min-width: 100%"
						class="ui raised {{$paginatedJadwal->hasMorePages() ? 'stacked' : '' }}
							segment selectable celled striped fixed padded collapsing small table"
						>
						<thead>
							<tr>
								<th>Nama Kapal</th>
								<th>Asal</th>
								<th>Jam</th>
								<th>Status</th>
								<th>Tiket</th>
								<th>Terakhir diubah</th>
								<th id="action-title" style="display: none;">Aksi</th>
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
								<td id="value-status_kapal" value="{{ $jadwal->status_kapal }}">
									{{ $jadwal->status_kapal }}
								</td>
								<td id="value-status_tiket" value="{{ $jadwal->status_tiket }}">
									{{ $jadwal->status_tiket }}
								</td>
								<td>
									<div><small>{{ date('d/m/Y', strtotime($jadwal->updated_at)) }}</small></div>
									<div><small>{{ date('H:i T', strtotime($jadwal->updated_at)) }}</small></div>
								</td>
								<td class="action action-edit positive collapsing single line" style="display: none;">
									<div><i class="edit icon"></i>Edit</div>
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
				</div>
			</div>
			<div class="row">
				@if($paginatedJadwal->total() > $paginatedJadwal->perPage())
				<div class="right aligned column">
					<div class="ui right floated pagination shadow menu">
						{{ $paginatedJadwal->links() }}
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="six wide column">
		<div class="row">
			<h2 class="ui header">Aksi</h2>
			<div class="right aligned two wide column">
				@if(count($paginatedJadwal->items()) > 0)
					<div class="ui three column grid">
						{{-- <div class="column">
							<div class="ui blue fluid shadow button action-button" id="create-button">
								<i class="plus icon"></i>
								Tambah
							</div>
						</div> --}}
						<div class="column">
							<div class="ui green fluid shadow button action-button" id="update-button">
								<i class="edit icon"></i>Update
							</div>
						</div>
						{{-- <div class="column">
							<div class="ui red fluid shadow button action-button" id="delete-button">
								<i class="trash icon"></i>
								Hapus
							</div>
						</div> --}}
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
						@if(count($topFiveJadwalLogs) > 0)
						@foreach ($topFiveJadwalLogs as $logJadwal)
						<tr>
							<td>
								{{ $logJadwal->aktivitas }}
							</td>
							<td>
								<div>{{ date('d/m/Y', strtotime($logJadwal->updated_at)) }}</div>
								<div>{{ date('H:i T', strtotime($logJadwal->updated_at)) }}</div>
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
		{{-- <div class="row changeable-segment" id="create-form-container" style="display: none">
			<form class="ui form error" id="create-form" method="POST" action="{{ route('web.jadwal.store') }}" enctype="multipart/form-data">
				@csrf
				<h2 class="ui blue header" id="form-title">Tambah Jadwal</h2>
				<div class="ui raised segment">
					<div class="field error-deactiveable">
						<div class="ui fluid search selection dropdown" id="create-kapal_id-dropdown">
							<input type="hidden" name="kapal_id">
							<i class="dropdown icon"></i>
							<div class="default text">Pilih Kapal</div>
						</div>
					</div>
					<div class="field error-deactiveable">
						<div class="ui fluid search selection dropdown" id="status_kegiatan-dropdown">
							<input type="hidden" name="status_kegiatan">
							<i class="dropdown icon"></i>
							<div class="default text">Pilih Jenis Kegiatan</div>
							<div class="menu">
								<div class="item" data-value="berangkat">Berangkat</div>
								<div class="item" data-value="datang">Datang</div>
							</div>
						</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('kota') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="map marker alternate icon"></i>
							<input type="text" id="create-kota" name="kota" placeholder="Masukkan Kota"
								value={{ old('kota') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('tanggal') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="calendar alternate outline icon"></i>
							<input type="date" id="create-tanggal" name="tanggal" placeholder="Masukkan Tanggal"
								value={{ old('tanggal') }}>
							</div>
					</div>
					<div class="field error-deactiveable {{ $errors->has('jam') ? 'error' : '' }}">
						<div class="ui left icon input">
							<i class="clock outline icon"></i>
							<input type="time" id="create-jam" name="jam" placeholder="Masukkan Jam"
								value={{ old('jam') }}>
							</div>
					</div>
					<div class="field error-deactiveable">
						<div class="ui fluid search selection dropdown" id="status_kapal-dropdown">
							<input type="hidden" name="status_kapal">
							<i class="dropdown icon"></i>
							<div class="default text">Pilih Status Kapal</div>
							<div class="menu">
								<div class="item" data-value="on schedule">On Schedule</div>
								<div class="item" data-value="delay">Delay</div>
								<div class="item" data-value="cancel">Cancel</div>
							</div>
						</div>
					</div>
					<div class="field error-deactiveable">
						<div class="ui fluid search selection dropdown" id="status_tiket-dropdown">
							<input type="hidden" name="status_tiket">
							<i class="dropdown icon"></i>
							<div class="default text">Pilih Status Tiket</div>
							<div class="menu">
								<div class="item" data-value="check in">Check in</div>
								<div class="item" data-value="boarding">Boarding</div>
							</div>
						</div>
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
		</div> --}}
		<div class="row changeable-segment" id="update-form-container" style="display: none">
			<form class="ui error form" id="update-form" method="POST" action="{{ route('web.jadwal.update', ['jadwal' => ':jadwal']) }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="PUT">
				<h2 class="ui green header" id="form-title">Edit Jadwal</h2>
				<div class="ui raised segment">
					<input type="hidden" name="id-update" value="{{ old('id-update') }}">
						{{-- <div class="field error-deactiveable {{ $errors->has('tanggal') ? 'error' : '' }}">
							<div class="ui left icon input">
								<i class="calendar alternate outline icon"></i>
								<input type="date" id="create-tanggal" name="tanggal" format placeholder="Masukkan Tanggal"
									value={{ old('tanggal') }}>
								</div>
						</div> --}}
						{{-- <div class="field error-deactiveable {{ $errors->has('jam') ? 'error' : '' }}">
							<div class="ui left icon input">
								<i class="clock outline icon"></i>
								<input type="time" id="create-jam" name="jam" placeholder="Masukkan Jam"
									value={{ old('jam') }}>
								</div>
						</div> --}}
						<div class="field error-deactiveable">
							<label for="status_tiket">Status</label>
							<div class="ui fluid search selection dropdown" id="status_tiket-dropdown">
								<input type="hidden" name="status_tiket">
								<i class="dropdown icon"></i>
								<div class="default text">Pilih Status Tiket</div>
								<div class="menu">
									<div class="item" data-value="check in">Check In</div>
									<div class="item" data-value="boarding">Boarding</div>
								</div>
							</div>
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
		{{-- <div id="delete-form-container" style="display: none">
			<form id="delete-form" method="POST" action="{{ route('web.jadwal.destroy', ['jadwal' => ':jadwal']) }}">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
			</form>
		</div> --}}
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
		$('#update-kapal_id-dropdown').dropdown('set selected', '');
		$('#update-kapal_id-dropdown').dropdown('set text', '');
		$('#status_kegiatan-dropdown').dropdown('set selected', '');
		$('input[name=kota]').val('');
		$('input[name=tanggal]').val('');
		$('input[name=jam]').val('');
		$('#status_kapal-dropdown').dropdown('set selected', '');
		$('#status_tiket-dropdown').dropdown('set selected', '');
	}

	function activateLastUpdate(){
		var id = "{{old('id-update')}}";
		var url = $('#update-form').attr('action');
		url = url.replace(':jadwal', id);
		$('#update-form').attr('action', url);
		$('#data-' + id).addClass('active');
		var status_kegiatan = "{{old('status_kegiatan')}}";
		var status_kapal = "{{old('status_kapal')}}";
		var status_tiket = "{{old('status_tiket')}}";
		$('#update-form #status_kegiatan-dropdown').dropdown('set selected', status_kegiatan);
		$('#update-form #status_kapal-dropdown').dropdown('set selected', status_kapal);
		$('#update-form #status_tiket-dropdown').dropdown('set selected', status_tiket);
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
		$('#search-form input[name=tanggal]').val(queryString.tanggal);
		$('#search-form #query-dropdown').dropdown('set selected', queryString.query);
		$('#search-form #query-dropdown').dropdown('set text', queryString.query);

		var failedUpdate = {{ session()->has('failedUpdate') ? 'true' : 'false' }};
		if(failedUpdate){
			$('#update-button').click();
			activateLastUpdate();
			toggleLogInformation(0);
			toggleUpdateForm(400);
			;
		}
	}

	// insert data to form
	function insertDataToUpdateForm(id, tanggal, jam, status_tiket){
		var url = $('#update-form').attr('action');
		url = url.replace(':jadwal', id);
		console.log(id, tanggal, jam, status_tiket);
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val(id);
		$('#update-form input[name=tanggal]').val(tanggal);
		$('#update-form input[name=jam]').val(jam);
		$('#update-form #status_tiket-dropdown').dropdown('set selected', status_tiket);
	}

  // reset update form to its normal state
	function resetUpdateFormData(){
		var url = $('#update-form').attr('action');
		url = url.replace(/\/[0-9]+$/, '/:jadwal');
		$('#update-form').attr('action', url);
		$('#update-form input[name=id-update]').val('');
		$('#update-form #update-kapal_id-dropdown').dropdown('set selected', '');
		$('#update-form #update-kapal_id-dropdown').dropdown('set text', '');
		$('#update-form #status_kegiatan-dropdown').dropdown('set selected', '');
		$('#update-form input[name=kota]').val('');
		$('#update-form input[name=tanggal]').val('');
		$('#update-form input[name=jam]').val('');
		$('#update-form #status_kapal-dropdown').dropdown('set selected', '');
		$('#update-form #status_tiket-dropdown').dropdown('set selected', '');
	}

	// reset create form to its normal state
	function resetCreateFormData(){
		$('#create-form #update-kapal_id-dropdown').dropdown('set selected', '');
		$('#create-form #update-kapal_id-dropdown').dropdown('set text', '');
		$('#create-form #status_kegiatan-dropdown').dropdown('set selected', '');
		$('#create-form input[name=kota]').val('');
		$('#create-form input[name=tanggal]').val('');
		$('#create-form input[name=jam]').val('');
		$('#create-form #status_kapal-dropdown').dropdown('set selected', '');
		$('#create-form #status_tiket-dropdown').dropdown('set selected', '');
	}

	function resetAllForm(){
		resetUpdateFormData();
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
		console.log(rowDataElement[0]);
		var id = rowDataElement.attr('value');
		var waktu = rowDataElement.find('#value-waktu').attr('value').split(' ');
		var tanggal = waktu[0];
		var jam = waktu[1];
		var status_tiket = rowDataElement.find('#value-status_tiket').attr('value');
		deactiveAllUpdateableRow();
		setSelectedEditRowToActive(rowDataElement);
		resetUpdateFormData();
		insertDataToUpdateForm(id, tanggal, jam, status_tiket);
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
			tanggal: {
				identifier  : 'tanggal',
				rules: [
					{
						type: 'empty',
						prompt: 'Tanggal tidak boleh kosong'
					},
				]
			},
			jam: {
				identifier  : 'jam',
				rules: [
					{
						type   : 'empty',
						prompt : 'Jam tidak boleh kosong'
					},
				]
			},
			kota: {
				identifier  : 'kota',
				rules: [
					{
						type   : 'empty',
						prompt : 'Kota tidak boleh kosong'
					},
				]
			},
			status_kegiatan: {
				identifier  : 'status_kegiatan',
				rules: [
					{
						type   : 'empty',
						prompt : 'Jenis Kegiatan tidak boleh kosong'
					}
				]
			},
			status_kapal: {
				identifier  : 'status_kapal',
				rules: [
					{
						type   : 'empty',
						prompt : 'Status Kapal tidak boleh kosong'
					}
				]
			},
			status_tiket: {
				identifier  : 'status_tiket',
				rules: [
					{
						type   : 'empty',
						prompt : 'Status Tiket tidak boleh kosong'
					}
				]
			},
			kapal_id: {
				identifier  : 'kapal_id',
				rules: [
					{
						type   : 'empty',
						prompt : 'Kapal tidak boleh kosong'
					}
				]
			},
		}
  });

	$('.message .close').on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  });

	$('#status_kegiatan-dropdown').dropdown({ clearable: true });
	$('#status_kapal-dropdown').dropdown({ clearable: true });
	$('#status_tiket-dropdown').dropdown({ clearable: true });

	$('#query-dropdown').dropdown({
    clearable: true,
		minCharacters: 2,
		apiSettings: {
			url: "{{ route('api.kapal.search') }}?query={query}",
			method: 'GET',
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
            name: item.nama,
            value: item.nama,
          });
        });
        return response;
      },
    },
		localSearch: false,
  });
</script>
@endsection
