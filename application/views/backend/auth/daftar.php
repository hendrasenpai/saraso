<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daftar</title>
	<link rel="icon" href="{{ASSETS_BACKEND}}img/favicon.ico" type="image/png">

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/fontawesome-free/css/all.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			<a href="{{ASSETS_BACKEND}}index2.html"><b>Daftar </b>Sobat Saraso</a>
		</div>

		<div class="card">
			<div class="card-body register-card-body">
				<div id='pageloader' class="overlay-wrapper">
					<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
						<div class="text-bold pt-2">Tunggu sebentar...</div>
					</div>
				</div>
				<p class="login-box-msg">Mohon Isi Form</p>

				{{form_open_multipart('', ['id'=>$form_id, 'class'=>'m-t', 'method'=>'POST', 'autocomplete'=>'off'])}}
				<div class="input-group mb-3">
					<input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Lengkap">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input id="no_hp" name="no_hp" type="text" class="form-control" placeholder="No HP">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-phone"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input id="username" name="username" type="text" class="form-control" placeholder="Username">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input id="password" name="password" type="password" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input id="passconf" name="passconf" type="password" class="form-control" placeholder="Retype password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<div class="custom-file">
						<input id="foto" name="foto" type="file" class="custom-file-input" accept="application/* images/*">
						<label for="foto" class="custom-file-label" id="label-foto">Pilih Foto</label>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						{{form_submit('submit', 'Simpan', 'class="btn btn-primary block full-width m-b float-right"')}}
					</div>
				</div>
				{{form_close()}}

				<a href="{{site_url('auth')}}" class="text-center">Saya sudah punya akun..</a>
			</div>
			<!-- /.form-box -->
		</div><!-- /.card -->
	</div>
	<!-- /.register-box -->

	<!-- jQuery -->
	<script src="{{ASSETS_BACKEND}}plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ASSETS_BACKEND}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- SweetAlert2 -->
	<script src="{{ASSETS_BACKEND}}plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- AdminLTE App -->
	<script src="{{ASSETS_BACKEND}}dist/js/adminlte.min.js"></script>
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


			$('#form-daftar').submit('click', function (event) {
				event.preventDefault();
				var formData = new FormData(this);
				formData.append(csrfName, csrfHash);
				$.ajax({
					method: "POST",
					url: "{{base_url('auth/aksi_daftar')}}",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "JSON",
					beforeSend: function () {
						$("pageloader").fadeIn();
					},
					success: function (data) {
						csrfName = data.csrfName;
						csrfHash = data.csrfHash;
						if (data.error) {
							$("pageloader").fadeOut();
							if (data.foto_error != '') {
								$('#foto').focus();
								Toast.fire({
									icon: 'warning',
									title: data.foto_error,
								});
							}
							if (data.passconf_error != '') {
								$('#passconf').focus();
								$('#passconf').prop('class', 'form-control is-invalid');
								Toast.fire({
									icon: 'warning',
									title: data.passconf_error,
								});
							} else {
								$('#passconf').prop('class', 'form-control is-valid');
							}
							if (data.password_error != '') {
								$('#password').focus();
								$('#password').prop('class', 'form-control is-invalid');
								Toast.fire({
									icon: 'warning',
									title: data.password_error,
								});
							} else {
								$('#password').prop('class', 'form-control is-valid');
							}
							if (data.username_error != '') {
								$('#username').focus();
								$('#username').prop('class', 'form-control is-invalid');
								Toast.fire({
									icon: 'warning',
									title: data.username_error,
								});
							} else {
								$('#username').prop('class', 'form-control is-valid');
							}
							if (data.no_hp_error != '') {
								$('#no_hp').focus();
								$('#no_hp').prop('class', 'form-control is-invalid');
								Toast.fire({
									icon: 'warning',
									title: data.no_hp_error,
								});
							} else {
								$('#no_hp').prop('class', 'form-control is-valid');
							}
							if (data.nama_error != '') {
								$('#nama').focus();
								$('#nama').prop('class', 'form-control is-invalid');
								Toast.fire({
									icon: 'warning',
									title: data.nama_error,
								});
							} else {
								$('#nama').prop('class', 'form-control is-valid');
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
									"{{base_url('auth')}}";
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
				if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
					document.getElementById("foto").value = "";
					Toast.fire({
						icon: 'error',
						title: 'Format foto tidak di dukung ! ekstensi file harus .jpg.png.jpeg',
					});
					$('#label-foto').addClass("selected").html('Pilih Foto');
				} else {
					if (size > 2154227) {
						document.getElementById("foto").value = "";
						Toast.fire({
							icon: 'error',
							title: 'Ukuran foto terlalu besar, maksimal 2mb',
						});
						$('#label-foto').addClass("selected").html('Pilih Foto');
						return true;
					} else {
						readURL(this);
					}
				}
			});
		});
	</script>
</body>

</html>
