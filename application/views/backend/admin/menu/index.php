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
					<li class="breadcrumb-item active">{{$title}}</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Default box -->
        <div class="card">
		<div class="card-header">
			<h3 class="card-title">{{$title}}</h3>
			<div class="card-tools">
				<span class="d-block m-t-5">
					<a class="btn btn-primary btn-sm" href="{{site_url('admin/menu/tambah')}}">Tambah</a>
				</span>
                
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="table" class="table table-bordered display nowrap" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Harga</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<!-- /.card-body -->
		<div class="card-footer">
			-
		</div>
		<!-- /.card-footer-->
	</div>
	<!-- /.card -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('backend.admin.menu.modal')
@endsection
@section('js')
<script>
	$(document).ready(function () {
        $('.select2').select2()
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
				"url": "{{site_url('admin/menu/fetch_table')}}",
				"type": "POST",
				"data": function (data) {
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = csrfHash;
				}
			},
			"columnDefs": [{
				"targets": [0, -1], // your case first column
				"className": "text-center",
				"orderable": false,
				"width": "4%",
				"responsivePriority" : 1,
			},{
				"targets": [1],
				"className" : "text-center"
			} ],
			"pageLength": 10
		});

        table.on('xhr.dt', function ( e, settings, json, xhr ) {
            csrfHash = json.csrfHash;
        });

		$('#table').on('click', '.hapus', function () {
			$('#modal-hapus').modal('show');
			$("#hapus-id").val($(this).data('id_menu'));
		});

		let Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});

		$('#form-hapus').submit('click', function () {
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			$.ajax({
				method: "POST",
				url: "{{base_url('admin/menu/aksi_hapus')}}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				success: function (data) {
					csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					$('#form-hapus')[0].reset();
					$('#modal-hapus').modal('hide');
					Toast.fire({
						icon: 'success',
						title: 'Data berhasil dihapus',
					});
					table.ajax.reload();
				},
				error: function (data) {
					Toast.fire({
						icon: 'error',
						title: 'Maaf, Data gagal dihapus',
					});
				}
			});
			return false;
		});
	});

</script>
@endsection
