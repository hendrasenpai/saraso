  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<!-- Brand Logo -->
  	<a href="#" class="brand-link">
  		<img src="{{ASSETS_BACKEND}}img/bintan.png" alt="Pemerintah Kabupaten Bintan" class="brand-image"
  			style="opacity: .8">
  		<span class="brand-text font-weight-light">{{$this->session->userdata('username')}}</span>
  	</a>

  	<!-- Sidebar -->
  	<div class="sidebar">
  		<!-- Sidebar user (optional) -->

  		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  			<div class="image">
  				<div id="profileImage"></div>
  			</div>
  			<div class="info">
  				<a href="#" class="text-center d-block text-orange">
  					<h6>Welcome Sobat Saraso!</h6>
  				</a>
  				<a href="#" id="firstName" class="d-block">{{$this->session->userdata('username')}}</a>
  			</div>

  		</div>

  		<!-- Sidebar Menu -->
  		<nav class="mt-2">
  			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
  				data-accordion="false">
  				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
  				@if($this->session->userdata('pengguna') == 'admin')
  				<li class="nav-item">
  					<a href="{{site_url('admin/dashboard')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'dashboard'): ?> active <?php endif?>">
  						<i class="nav-icon fas fa-tachometer-alt"></i>
  						<p>
  							Dashboard
  						</p>
  					</a>
  				</li>
  				<li class="nav-item">
  					<a href="{{site_url('admin/transaksi')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'transaksi'): ?> active <?php endif?>">
  						<i class="nav-icon fa fa-balance-scale"></i>
  						<p>
  							Transaksi
  						</p>
  					</a>
  				</li>
  				<li class="nav-item">
  					<a href="{{site_url('admin/user')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'user'): ?> active <?php endif?>">
  						<i class="nav-icon far fa-user"></i>
  						<p>
  							User
  						</p>
  					</a>
  				</li>
  				<li class="nav-item">
  					<a href="{{site_url('admin/menu')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'menu'): ?> active <?php endif?>">
  						<i class="nav-icon fa fa-cheese"></i>
  						<p>
  							Menu
  						</p>
  					</a>
  				</li>

  				@else
  				<li class="nav-item">
  					<a href="{{site_url('user/dashboard')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'dashboard'): ?> active <?php endif?>">
  						<i class="nav-icon fas fa-tachometer-alt"></i>
  						<p>
  							Dashboard
  						</p>
  					</a>
  				</li>
  				<li class="nav-item">
  					<a href="{{site_url('user/profil')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'profil'): ?> active <?php endif?>">
  						<i class="nav-icon fas fa-user"></i>
  						<p>
  							Profil
  						</p>
  					</a>
  				</li>
  				<li class="nav-item">
  					<a href="{{site_url('user/transaksi')}}"
  						class="nav-link <?php if ($this->uri->segment(2) == 'transaksi'): ?> active <?php endif?>">
  						<i class="nav-icon fa fa-balance-scale"></i>
  						<p>
  							Transaksi
  						</p>
  					</a>
  				</li>
  				@endif
  				<li class="nav-item">
  					<a href="{{site_url('auth/keluar')}}" class="nav-link ">
  						<i class="nav-icon fas fa-arrow-left"></i>
  						<p>
  							Logout
  						</p>
  					</a>
  				</li>

  			</ul>
  		</nav>
  		<!-- /.sidebar-menu -->
  	</div>
  	<!-- /.sidebar -->
  </aside>
