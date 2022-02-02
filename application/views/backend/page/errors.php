@extends('backend.layout.main')
@section('content')
@section('title', $title)
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> {{$title}}</h2>
        <div class="error-content">
          <h3><i class="fas fa-key text-warning"></i> Anda tidak memiliki akses</h3>
              <p>
                Harap hubungi admin SiBakri, Terima Kasih.
              </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
@endsection

