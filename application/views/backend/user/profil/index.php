@extends('backend.layout.main')
@section('content')
@section('title', $title)
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{$title}}</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{site_url('user/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">{{$title}}</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="card card-solid">
		<div class="card-body pb-0">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 d-flex align-items-stretch flex-column">
					<div class="card bg-light d-flex flex-fill">
						<div class="card-header text-muted border-bottom-0">
							{{$profil['nama']}}

						</div>
						<div class="card-body pt-0">
							<div class="row">
								<div class="col-7">
									<h2 class="lead"><b> {{$profil['username']}}</b></h2>
									@if($profil['status'] == 'aktif')
									<p class="text-muted text-sm"><b>Status: </b> <span
											class="badge badge-success">Aktif</span></p>
									@else
									<p class="text-muted text-sm"><b>Status: </b> <span class="badge badge-danger">Tidak
											Aktif</span></p>

									@endif
									<ul class="ml-4 mb-0 fa-ul text-muted">
										<li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
											{{$profil['no_hp']}}</li>
										<li class="small"><span class="fa-li"><i
													class="fas fa-lg fa-calendar"></i></span>
											Akun ini dibuat pada {{shortdate($profil['created_on'])}}</li>
									</ul>
								</div>
								<div class="col-5 text-center">
									<img src="{{site_url('upload/').$profil['foto']}}" alt="user-avatar"
										class="img-circle img-fluid" width="50%">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="text-right">
								<a href="{{site_url('user/profil/ubah?id_user=') . urlencode($this->encryption->encrypt($profil['id_user']))}}" class="btn btn-sm btn-primary">
									<i class="fas fa-user"></i> Ubah Profil
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
@endsection
@section('js')
<script>
	$(document).ready(function () {

		let Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});

		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	});

</script>
@endsection
