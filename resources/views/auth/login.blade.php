@extends('layouts.index')
@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-5 my-4 py-5">
          <div class="card shadow-ic">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <div class=" text-center">
                        <img src="/img/logo_2.jpg" alt="logo" width="85">
                        <h4 class="mt-3 text-center">RM โรงพยาบาลหนองหงส์</h4>
                    </div>
                  <hr />
                  <div>
                    <h5>ชื่อผู้ใช้</h5>
                    <form method="POST" action="{{ route('login-auth') }}">
                       @csrf
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="username" type="text" name=" username" class="form-control" placeholder="กรุณากรอก ชื่อผู้ใช้งาน" aria-describedby="inputGroup-sizing-default" />
                      </div>

                      <h5>รหัสผ่าน</h5>
                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-lock "></i></span>
                        </div>
                        <input id="password" type="password" name="password" class="form-control " placeholder="กรุณากรอก รหัสผ่าน" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"/>
                      </div>
                      <button type="submit" class=" btn btn-success btn-block btn-lg">LOGIN</button>
                    </form>

                    <hr />
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <a href="/register">ลงทะเบียนใช้งานระบบ</a>
                      </div>
                      <div class="col-md-6 text-right">
                        <a href="/about"><span class=" text-secondary">เกี่ยวกับเรา</span></a>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer bg-foot-b text-light text-center mt-1">
              <small>© 2020 โรงพยาบาลหนองหงส์ Vsersion: <?php echo env("VERSION"); ?> BY Samitra</small>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
