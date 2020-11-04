
<div class="wrapper" style="background:rgb(0,0,0,0)">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    @switch(Request::path())
    @case("/")
    @case("register")
    @case("login")
        @break
    @default
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    @endswitch
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">{{ config('app.name', 'Laravel') }}</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @guest
        <li class="nav-item">
            <a class="nav-link"  href="{{ route('register') }}" >
            REGISTRAR
            </a>
        </li>
      @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
      @endguest
    </ul>
  </nav>
  <!-- /.navbar -->
  @switch(Request::path())
    @case("/")
    @case("register")
    @case("login")
        @break
    @default
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('img/icono.jpg')}}"
           alt="Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MENU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{!! Auth::user()->avatar? Illuminate\Support\Facades\Storage::url(Auth::user()->avatar->url): asset('dist/img/avatar.png') !!}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('user.config',Auth::user())}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-header">IVA</li>
            <li class="nav-item">
              <a href="{{route('proveedor.index')}}" class="nav-link">
                <i class="fas fa-briefcase nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('cliente.index')}}" class="nav-link">
                <i class="fas fa-user nav-icon"></i>
                <p>Cliente</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('gestion.index')}}" class="nav-link">
                <i class="fas fa-book nav-icon"></i>
                <p>Gestiones</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.config',Auth::user())}}" class="nav-link">
                <i class="fas fa-cog nav-icon"></i>
                <p>Configuraciones</p>
              </a>
            </li>
           
          </li>         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

  </aside>
@endswitch
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="background:rgb(0,0,0,0.0)">
    <br>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->