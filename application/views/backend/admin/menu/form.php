@extends('backend.layout.main')
@section('content')
@section('title',$title)
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{$title}}</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{site_url('admin/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{site_url('admin/menu')}}">Lauk</a></li>
					<li class="breadcrumb-item active">{{$title}}</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<section class="content">
	{{form_open_multipart('', ['id'=>$form_id, 'class'=>'m-t', 'method'=>'POST', 'autocomplete'=>'off'])}}
	<div class="card card card-outline card-primary">
		<div class="card-body">
			<div id='pageloader' class="overlay-wrapper">
				<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Tunggu sebentar...</div></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" hidden>
						<label for="id_menu">ID</label>
						<input type="text" class="form-control" id="id_menu" name="id_menu" value="{{$id_menu}}" readonly>
					</div>
					<div class="form-group">
						<label for="nama">Nama Lauk</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="nama" name="nama"
								value="{{$nama}}" placeholder="Masukkan nama menu">
						</div>
						<div id="nama-msg"></div>	
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
						<label for="harga">Harga Lauk</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="harga" name="harga"
								value="{{$harga}}" placeholder="Masukkan harga menu" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" data-mask>
						</div>
						<div id="harga-msg"></div>	
					</div>
				</div>

			</div>
		</div>
		<div class="card-footer">
			{{form_submit('submit', 'Simpan', 'class="btn btn-primary block full-width m-b float-right"')}}
		</div>
	</div>
	{{form_close()}}
</section>
@endsection
@section('js')
<script>
	$(document).ready(function () {
		$("#pageloader").fadeOut();

	    $('[data-mask]').inputmask()

		let Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});

		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
			
	
		$('#form-tambah').submit('click', function (event) {
			$('[data-mask]').inputmask('unmaskedvalue');
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			formData.append('harga', $('#harga').inputmask('unmaskedvalue'));
			$.ajax({
				method: "POST",
				url: "{{base_url('admin/menu/aksi_tambah')}}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function (){
					$("pageloader").fadeIn();
                },
				success: function (data) {
					csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					if (data.error) {
						$("#pageloader").fadeOut();
						if (data.nama_error != '') {
							$('#nama').focus();
							$('#nama').prop('class', 'form-control is-invalid');
							$('#nama-msg').html(data.nama_error);
						} else {
							$('#nama').prop('class', 'form-control is-valid');
							$('#nama-msg').html('');
						}

						if (data.harga_error != '') {
							$('#harga').focus();
							$('#harga').prop('class', 'form-control is-invalid');
							$('#harga-msg').html(data.harga_error);
						} else {
							$('#harga').prop('class', 'form-control is-valid');
							$('#harga-msg').html('');
						}
						
					} else {
						$("#pageloader").fadeIn();					
						Toast.fire({
							icon: 'success',
							title: 'Lauk berhasil ditambahkan',
						});
						$('#form-tambah').trigger("reset");
						setTimeout(function () {
							window.location.href =
								"{{base_url('admin/menu')}}";
						}, 1000);
					}
				},
				error: function (data) {
					Toast.fire({
						icon: 'error',
						title: 'Lauk gagal ditambah',
					});
				}
			});
			return false;
		});

		$('#form-ubah').submit('click', function (event) {
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			formData.append('harga', $('#harga').inputmask('unmaskedvalue'));
			$.ajax({
				method: "POST",
				url: "{{base_url('admin/menu/aksi_ubah')}}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function (){
					$("pageloader").fadeIn();
				},
				success: function (data) {
					csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					if (data.error) {
						$("pageloader").fadeOut();
						if (data.nama_error != '') {
							$('#nama').focus();
							$('#nama').prop('class', 'form-control is-invalid');
							$('#nama-msg').html(data.nama_error);
						} else {
							$('#nama').prop('class', 'form-control is-valid');
							$('#nama-msg').html('');
						}

						if (data.harga_error != '') {
							$('#harga').focus();
							$('#harga').prop('class', 'form-control is-invalid');
							$('#harga-msg').html(data.harga_error);
						} else {
							$('#harga').prop('class', 'form-control is-valid');
							$('#harga-msg').html('');
						}
						
					} else {
						$("#pageloader").fadeIn();					
						Toast.fire({
							icon: 'success',
							title: 'Lauk berhasil diubah',
						});
						$('#form-ubah').trigger("reset");
						setTimeout(function () {
							window.location.href =
							"{{base_url('admin/menu/ubah?id_menu='.$id_menu)}}";
						}, 1000);
					}
				},
				error: function (data) {
					Toast.fire({
						icon: 'error',
						title: 'Lauk gagal diubah',
					});
				}
			});
			return false;
		});

	});
</script>
@endsection
