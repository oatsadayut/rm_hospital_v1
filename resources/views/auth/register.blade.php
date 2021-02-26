@extends('layouts.index')
@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 my-5 pt-5 mb-3">
          <div class="card shadow-ic mt-5">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <div class=" text-center">
                        <img src="/img/<?php echo env("APP_LOGO_FILENAME"); ?>" alt="logo" width="85">
                        <h4 class="mt-3 text-center">ลงทะเบียนเข้าใช้งาน ระบบ RM</h4>
                    </div>
                  <hr />
                  <div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h5>เลขบัตรประชาชน</h5>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-address-card"></i></span>
                            </div>
                            <input id="cid" type="number" name=" cid" class="form-control" placeholder="กรุณากรอก เลขบัตรประชาชน" aria-describedby="inputGroup-sizing-default" />
                        </div>

                        <h5>ชื่อผู้ใช้</h5>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="username" type="text" name=" username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="กรุณากรอก ชื่อผู้ใช้งาน" aria-describedby="inputGroup-sizing-default" />
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <h5>รหัสผ่าน</h5>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-lock "></i></span>
                            </div>
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="กรุณากรอก รหัสผ่าน" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"/>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <h5>ยืนยันรหัสผ่าน</h5>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-foot-b text-light" id="inputGroup-sizing-default"><i class="fas fa-lock "></i></span>
                            </div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="กรุณากรอก ยืนยันรหัสผ่าน" required autocomplete="new-password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <button type="submit" class=" btn btn-success btn-block btn-lg">REGISTER</button>
                    </form>
                    <div class=" my-3">
                        <span>
                           เงื่อนไขการลงทะเบียน
                        </span>
                        <p>
                            - ต้องมีเลขบัตรประชาชนในระบบก่อน ( Person CID ) <br>
                            - ชื่อผู้ใช้งานต้องไม่ซ้ำกัน ( Username ) <br>
                            - รหัสผ่านอย่างน้อย 6 ตัวอักษร<br>
                            - การเข้าใช้งานต้องได้รับการอนุมิตจากผู้ดูแลระบบก่อนเท่านั้น<br>
                        </p>
                    </div>
                    <hr />
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <a href="/">< ย้อนกลับ</a>
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
                <small>© 2020 <?php echo env("APP_TITLE"); ?> Version: <?php echo env("VERSION"); ?> BY Samitra</small>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
