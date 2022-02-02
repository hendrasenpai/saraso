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
					<li class="breadcrumb-item"><a href="{{site_url('user/dashboard')}}">Dashboard</a></li>
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
				<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
					<div class="text-bold pt-2">Tunggu sebentar...</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="callout callout-info">
						<h5><i class="fas fa-info"></i> Catatan:</h5>
						Aplikasi masih dalam pengembangan, sementara untuk buat pesanan hanya untuk 1 bungkus, Terima Kasih ^^
					</div>
				</div>
				<div class="col-md-12" hidden>
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text" class="form-control" id="id_transaksi" name="id_transaksi"
							value="{{$id_transaksi}}" readonly>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-control-label">Menu</label>
						<div class="input-group input-group-md">
							<select class="form-control select2" multiple="multiple" id="menu" name="menu[]"
								placeholder="Pilih menu">
								@foreach(option('menu') as $value)
								<option value="{{$value->id_menu}}"
									{{set_select('menu', $value->id_menu, ($value->id_menu ==  $menu));}}>
									{{$value->nama}} - {{$value->harga}}</option>
								@endforeach
							</select>
							<input type="text" class="form-control" id="total_harga" name="total_harga"
								value="{{$total_harga}}" placeholder="Total Harga"
								data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'"
								data-mask readonly>
						</div>
						<div id="menu-msg"></div>

					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<div class="input-group mb-3">
							<textarea id="keterangan" name="keterangan" class="form-control" rows="5"
								value="{{$keterangan}}" placeholder="Masukkan Keterangan (Opsional) Misalnya Tak Pakai Sayur, Kuah dll"></textarea>
						</div>
						<div id="keterangan-msg"></div>
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
		$('.select2').select2();
		$('#menu').select2({
			placeholder: "Pilih Menu",
			allowClear: true
		});

		$("#pageloader").fadeOut();
		$('[data-mask]').inputmask();

		let Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});

		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

		$('#menu').change(function () {
			$.ajax({
				url: "{{base_url('user/transaksi/data_harga')}}",
				method: "POST",
				data: {
					[csrfName]: csrfHash,
					menu: $('#menu').val()
				},
				async: false,
				dataType: "json",
				success: function (data) {
					csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					$("#total_harga").val(data.result);
				}
			})
		});

		$('#form-tambah').submit('click', function (event) {
			$('[data-mask]').inputmask('unmaskedvalue');
			event.preventDefault();
			var formData = new FormData(this);
			formData.append(csrfName, csrfHash);
			formData.append('total_harga', $('#total_harga').inputmask('unmaskedvalue'));
			$.ajax({
				method: "POST",
				url: "{{base_url('user/transaksi/aksi_tambah')}}",
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
						if (data.menu_error != '') {
							$('#menu').focus();
							$('#menu-msg').html(data.menu_error);
						} else {
							$('#menu-msg').html('');
						}
					} else {
						$("#pageloader").fadeIn();
						Toast.fire({
							icon: 'success',
							title: 'Transaksi berhasil ditambah',
						});
						$('#form-ubah').trigger("reset");
						setTimeout(function () {
							window.location.href =
								"{{base_url('user/transaksi')}}";
						}, 1000);
					}
				},
				error: function (data) {
					Toast.fire({
						icon: 'error',
						title: 'Transaksi gagal ditambah',
					});
				}
			});
			return false;
		});
	});
</script>
@endsection