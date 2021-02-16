<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RM โรงพยาบาลหนองหงส์</title>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('chart.js/dist/Chart.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/temapp.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">

    <link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

</head>
<body>
    @include('sweetalert::alert')

    <nav class="navbar navbar-dark sticky-top bg-foot-b flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">RM โรงพยาบาลหนองหงส์ <small>v.<?php echo env("VERSION"); ?></small></a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                [{{Auth::user()->username}}] ออกจากระบบ
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </li>
        </ul>
    </nav>

      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-white sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link " href="/">
                    <i class="fas fa-home"></i> <span class="text-rm-b">HOME</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/regrm">
                    <i class="fas fa-registered"></i> ลงความเสี่ยง
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/managerrm">
                    <i class="fas fa-tasks"></i> จัดการความเสี่ยง
                  </a>
                </li>
                @if (Auth::user()->permission >= 2)
                    <li class="nav-item">
                        <a class="nav-link" href="/rm/report">
                            <i class="fas fa-book-open"></i> รายงาน
                        </a>
                    </li>
                @endif
              </ul>

              @if (Auth::user()->permission == 3 || Auth::user()->permission == 4)
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Admin Panal</span>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link" href="/person">
                    <i class="fas fa-users"></i> บุคลากรในระบบ
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/user">
                    <i class="fas fa-user-lock"></i> ผู้มีสิทธิ์ใช้งานระบบ
                  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/rmcode">
                        <i class="fas fa-receipt"></i> ตั้งค่ารหัสต่างๆ
                    </a>
                </li>
                {{-- @if (Auth::user()->permission == 4)
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-tools"></i> ตั้งค่าระบบ <small class=" text-danger">อยู่ในระหว่างพัฒนา</small>
                    </a>
                </li>
                @endif --}}
              </ul>
              @endif

            </div>
          </nav>

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-0 bg-muted">
            @yield('content')
          </main>

        </div>
      </div>


<script src="{{ asset('js/temapp.js') }}"></script>
<script src="{{ asset('chart.js/dist/Chart.bundle.min.js')}}"></script>
<script src="{{ asset('js/datatable.js') }}"></script>
<script src="{{ asset('js/datablebootstrap.js') }}"></script>
<script src="{{ asset('select2/dist/js/select2.min.js') }}" rel="stylesheet" ></script>
</body>
</html>
