<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
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

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{site_url()}}"><img class="img-fluid" src="{{ASSETS_BACKEND}}img/bintan.png" width="50%"
					oppacity="0.8" /> </a>
		</div>
		<!-- /.login-logo -->
		<div class="card">

			<div class="card-body login-card-body">
				@if($this->session->flashdata('pesan'))
				<div class="alert alert-success alert-dismissable">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					{{$this->session->flashdata('pesan')}}
				</div>
				@else
				<p class="login-box-msg">Halaman login</p>
				@endif
				{{form_open('',['id'=>'form-login','class'=>'m-t','role'=>'form'])}}
				<div class="input-group mb-3">
					<input id="username" name="username" type="text" class="form-control"
						placeholder="Masukkan username" value="{{set_value('username')}}">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
					{{form_error('username')}}
				</div>
				<div class="input-group mb-3">
					<input id="password" name="password" type="password" class="form-control"
						placeholder="Masukkan password" value="{{set_value('password')}}">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
					{{form_error('password')}}
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-dark btn-md btn-block" tabindex="3">
						Login <i class="fas fa-sign-in-alt"></i>
					</button>
				</div>
				{{form_close()}}
				<p class="mb-0">
					<a href="{{site_url('auth/daftar')}}" class="text-center">Ingin mejadi member saraso? Daftar
						disini</a>
				</p>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{ASSETS_BACKEND}}plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ASSETS_BACKEND}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- SweetAlert2 -->
	<script src="{{ASSETS_BACKEND}}plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- AdminLTE App -->
	<script src="{{ASSETS_BACKEND}}dist/js/adminlte.min.js"></script>
	<script>
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

		let Toast = Swal.mixin({
			toast: true,
			position: 'top',
			showConfirmButton: false,
			timer: 5000
		});

		$('#form-login').submit('click', function (event) {
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			$.ajax({
				method: "POST",
				url: "{{base_url($action)}}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				success: function (data) {
					csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					if (data.error) {
						if (data.alert != '') {
							Toast.fire({
								icon: 'error',
								title: data.alert,
							});
						}
					} else if (data.success) {
						Toast.fire({
							icon: 'success',
							title: 'Berhasil masuk ke sistem',
						});
						$('#form-login').trigger("reset");
						if (data.pengguna == 'admin') {
							setTimeout(function () {
								window.location.href = "{{base_url('admin/dashboard')}}";
							}, 1000);
						}else{
							setTimeout(function () {
								window.location.href = "{{base_url('user/dashboard')}}";
							}, 1000);
						}

					}
				},
				error: function (data) {
					Toast.fire({
						icon: 'warning',
						title: 'Gagal login ke sistem',
					});
				}
			});
			return false;
		});
	</script>
</body>

</html>