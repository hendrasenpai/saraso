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
					<li class="breadcrumb-item"><a href="{{site_url('admin/user')}}">User</a></li>
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
						<label for="id_user">ID</label>
						<input type="text" class="form-control" id="id_user" name="id_user" value="{{$id_user}}" readonly>
					</div>
					<div class="form-group">
						<label for="nama">Nama</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="nama" name="nama" value="{{$nama}}"
								placeholder="Masukkan nama">
						</div>
						<div id="nama-msg"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="no_hp">No HP</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="no_hp" name="no_hp" value="{{$no_hp}}"
								placeholder="Masukkan No HP">
						</div>
						<div id="no_hp-msg"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="username">Username</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="username" name="username" value="{{$username}}"
								placeholder="Masukkan Username">
						</div>
						<div id="username-msg"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="status">Status</label>
						<select class="form-control" id="status" name="status">
							<option value="aktif" {{set_select('status', 'aktif', ('aktif'==  $status));}}>Aktif</option>
							<option value="tidak" {{set_select('status', 'tidak', ('tidak'==  $status));}}>Tidak Aktif</option>
						</select>
						<div id="status-msg"></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="foto">Foto</label>
						<div class="custom-file">
							<input id="foto" name="foto" type="file" class="custom-file-input" accept="application/* images/*">
							<label for="foto" class="custom-file-label" id="label-foto">Pilih Foto (Ukuran Maksimal 2 mb)</label>
						</div>
						<div id="foto-msg"></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						@if(!empty($old_foto))
						<img id="blah" src="{{site_url()}}upload/{{$old_foto}}" class="img-fluid">
						@else
						<img id="blah" src="{{site_url()}}assets/backend/img/not-found33.png" class="img-fluid">
						@endif
						<input type="hidden" class="form-control" id="old_foto" name="old_foto" value="{{$old_foto}}" readonly>
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

		let Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});

		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


		$('#form-ubah').submit('click', function (event) {
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			$.ajax({
				method: "POST",
				url: "{{base_url('admin/user/aksi_ubah')}}",
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

						if (data.no_hp_error != '') {
							$('#no_hp').focus();
							$('#no_hp').prop('class', 'form-control is-invalid');
							$('#no_hp-msg').html(data.no_hp_error);
						} else {
							$('#no_hp').prop('class', 'form-control is-valid');
							$('#no_hp-msg').html('');
						}

						if (data.username_error != '') {
							$('#username').focus();
							$('#username').prop('class', 'form-control is-invalid');
							$('#username-msg').html(data.username_error);
						} else {
							$('#username').prop('class', 'form-control is-valid');
							$('#username-msg').html('');
						}

						if (data.status_error != '') {
							$('#status').focus();
							$('#status').prop('class', 'form-control is-invalid');
							$('#status-msg').html(data.status_error);
						} else {
							$('#status').prop('class', 'form-control is-valid');
							$('#status-msg').html('');
						}
					} else {
						$("#pageloader").fadeIn();
						Toast.fire({
							icon: 'success',
							title: 'User berhasil diubah',
						});
						$('#form-ubah').trigger("reset");
						setTimeout(function () {
							window.location.href =
							"{{base_url('admin/user/ubah?id_user='.$id_user)}}";
						}, 1000);
					}
				},
				error: function (data) {
					Toast.fire({
						icon: 'error',
						title: 'User gagal diubah',
					});
				}
			});
			return false;
		});

		$('input[type="file"]').change(function (e) {
			var fileName = e.target.files[0].name;
			$('.custom-file-label').html(fileName);
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#blah').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]); // convert to base64 string
			}
		}
		$("#foto").change(function () {
			files = this.files;
			size = files[0].size;

			var ext = $('#foto').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				document.getElementById("foto").value = "";
				Toast.fire({
					icon: 'error',
					title: 'Format foto tidak di dukung ! ekstensi file harus .jpg.png.jpeg',
				});
				$('#label-foto').addClass("selected").html('Pilih Foto (Ukuran Maksimal 2 mb)');
			}else{
					if (size > 2154227) {
					document.getElementById("foto").value = "";
					Toast.fire({
						icon: 'error',
						title: 'Ukuran foto terlalu besar, maksimal 2mb',
					});
					$('#label-foto').addClass("selected").html('Pilih Foto (Ukuran Maksimal 2 mb)');
					return true;
				} else {
					readURL(this);
				}
			}
		});
	});
</script>
@endsection
