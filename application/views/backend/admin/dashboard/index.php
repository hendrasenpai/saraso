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
						<h4>User</h4>
						<hr />
					</div>
					<div class="icon">
						<i class="fa fa-drumstick-bite"></i>
					</div>
					<a href="{{base_url('admin/user')}}" class="small-box-footer">Klik Disini <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-6 col-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h4>Transaksi  : {{$jumlah_transaksi}}</h4>
						<hr/>
						<h6>Detail Transaksi</h6>
						<ul class="nav flex-column">
						<li class="nav-item">
							<a href="#" class="nav-link text-white">
								Hari Ini <span
									class="float-right badge bg-maroon">{{$jumlah_transaksi_today}}</span>
							</a>
						</li>
					</ul>
					</div>
					<div class="icon">
						<i class="fa fa-balance-scale"></i>
					</div>
					<a href="{{base_url('admin/transaksi')}}" class="small-box-footer">Klik Disini <i
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

		let table = $('#table').DataTable({
			"language": {
				"lengthMenu": "Tampilkan _MENU_ data per halaman",
				"infoEmpty": "Data kosong",
				"zeroRecords": "Data tidak ada",
				"info": "Menampilkan halaman _PAGE_ dari _PAGES_",
				"infoFiltered": "(difilter dari _MAX_ total data)",
				"paginate": {
					"first": "Pertama",
					"last": "Terakhir",
					"next": "Selanjutnya",
					"previous": "Sebelumnya"
				},
			},
			"dom": "lTfgitp",
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"order": [],
			"ajax": {
				"url": "{{site_url('admin/dashboard/fetch_table')}}",
				"type": "POST",
				"data": function (data) {
					data. <?php echo $this->security-> get_csrf_token_name(); ?> = csrfHash;
				}
			},
			"columnDefs": [{
				"targets": [0, 1], // your case first column
				"className": "text-center",
				"orderable": false,
				"width": "4%",
				"responsivePriority": 1,
			}],
			"pageLength": 10
		});

		table.on('xhr.dt', function (e, settings, json, xhr) {
			csrfHash = json.csrfHash;
		});
	});

</script>
@endsection
