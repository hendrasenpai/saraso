<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Web" />
	<meta name="keywords" content="Web" />
    <meta name="theme-color" content="#0b519f">
    <meta name="msapplication-navbutton-color" content="#0b519f">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0b519f">
	<title><?php echo $title ?></title>
	<!-- Favicon -->
	<link rel="icon" href="{{ASSETS_BACKEND}}img/favicon.ico" type="image/png">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/fontawesome-free/css/all.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet"
		href="{{ASSETS_BACKEND}}plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/daterangepicker/daterangepicker.css">

	<!-- DataTables -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/highchart/highchart.css">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<!-- BS Stepper -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/bs-stepper/css/bs-stepper.min.css">
	<!-- dropzonejs -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/dropzone/min/dropzone.min.css">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}plugins/summernote/summernote-bs4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}dist/css/adminlte.min.css">
	<link rel="stylesheet" href="{{ASSETS_BACKEND}}dist/css/style.css">



</head>

<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		@include('backend.layout.navbar')
		@include('backend.layout.sidebar')
		<div class="content-wrapper">
			@yield('content')
		</div>
		@include('backend.layout.footer')
	</div>

	<!-- jQuery -->
	<script src="{{ASSETS_BACKEND}}plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ASSETS_BACKEND}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Select2 -->
	<script src="{{ASSETS_BACKEND}}plugins/select2/js/select2.full.min.js"></script>
	<!-- date-range-picker -->
	<script src="{{ASSETS_BACKEND}}plugins/moment/moment.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap color picker -->
	<script src="{{ASSETS_BACKEND}}plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ASSETS_BACKEND}}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Bootstrap Switch -->
	<script src="{{ASSETS_BACKEND}}plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
	<!-- BS-Stepper -->
	<script src="{{ASSETS_BACKEND}}plugins/bs-stepper/js/bs-stepper.min.js"></script>
	<!-- dropzonejs -->
	<script src="{{ASSETS_BACKEND}}plugins/dropzone/min/dropzone.min.js"></script>
	<!-- DataTables  & Plugins -->
	<script src="{{ASSETS_BACKEND}}plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/jszip/jszip.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/pdfmake/pdfmake.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/pdfmake/vfs_fonts.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- SweetAlert2 -->
	<script src="{{ASSETS_BACKEND}}plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- InputMask -->
	<script src="{{ASSETS_BACKEND}}plugins/inputmask/jquery.inputmask.min.js"></script>
	<!-- HighChart -->
	<script src="{{ASSETS_BACKEND}}plugins/highchart/highchart.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/highchart/modules/exporting.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/highchart/modules/export-data.js"></script>
	<script src="{{ASSETS_BACKEND}}plugins/highchart/modules/accessibility.js"></script>
	<!-- Summernote -->
	<script src="{{ASSETS_BACKEND}}plugins/summernote/summernote-bs4.min.js"></script>
	<!-- AdminLTE App -->
	<script src="{{ASSETS_BACKEND}}dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ASSETS_BACKEND}}dist/js/demo.js"></script>
	<script>
		$(document).ready(function () {
			var firstName = $('#firstName').text();
			var intials = $('#firstName').text().charAt(0);
			var profileImage = $('#profileImage').text(intials);
		});
	</script>
	@yield('js')
</body>

</html>
