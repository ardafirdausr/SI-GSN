@extends('layouts.app')
@section('title')
	Tambah Jadwal Pelayaran
@endsection
@section('content')
<div class="ui container">
	<div class="ui form">
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
		<div class="field">
			<label class="three wide column">Tanggal Kedatangan</label>
			<input class="four wide column" type="time" placeholder="Full Name">
		</div>
	</div>
</div>
	{{-- <div class="ui grid containers">
		<div class="row">
			<div class="inline grid field">
				<label class="three wide column">Tanggal Keberangkatan</label>
				<input class="four wide column" type="date" placeholder="Full Name">
			</div>
			<div class="one wide column"></div>
			<div class="field">
				<label class="three wide column">Jam Keberangkatan</label>
				<input class="four wide column" type="time" placeholder="Full Name">
			</div>
		</div>
		<div class="row">
			<label class="three wide column">Tanggal Kedatangan</label>
			<input class="four wide column" type="date" placeholder="Full Name">
			<div class="one wid column"></div>
			<label class="three wide column">Jam Kedatangan</label>
			<input class="four wide column" type="time" placeholder="Full Name">
		</div>
		<div class="inline field row">
			<label class="three wide column">Maskapai</label>
			<input class="four wide column" type="date" placeholder="Full Name">
		</div>
		<div class="inline field row">
			<label class="three wide column">Kapal</label>
			<input class="for wide column" type="text" placeholder="Full Name">
		</div>
	</div> --}}
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
			var clickedElement = $(this);
			$('.ui.mini.basic.modal.delete-modal').modal({
					closable  : true,
					// onDeny    : function(){
					// 	window.alert('Wait not yet!');
					// 	return false;
					// },
					onApprove : function() {
						$.ajax({
							url: "/api/jadwal/" + clickedElement.children('input[name="id"]').val(),
							method: 'DELETE',
							complete: function(response){
								console.log(response);
							}
						})
					}
			}).modal('show');
		});
		function render(){
			$('.loading').removeClass('active');
		}
		render();
	</script>
@endsection