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
					<li class="breadcrumb-item active"><a href="#">Dashboard</a></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-6">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">
						<h4>Buat Pesanan</h4>
						<hr />
					</div>
					<div class="icon">
						<i class="fa fa-drumstick-bite"></i>
					</div>
					<a href="{{base_url('user/transaksi/tambah')}}" class="small-box-footer">Klik Disini <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-6 col-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h4>Transaksi</h4>
						<hr />
					</div>
					<div class="icon">
						<i class="fa fa-balance-scale"></i>
					</div>
					<a href="{{base_url('user/transaksi')}}" class="small-box-footer">Klik Disini <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('js')
<script>
	$(document).ready(function () {

		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	});

</script>
@endsection
