@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="/img/logo_2.jpg" alt="logo" width="150">
                    <h2 class=" mt-2">RM โรงพยาบาลหนองหงส์</h2>
                    <h4>ระบบบันทึกความเสี่ยง โรงพยาบาล</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <a href="/regrm" class=" btn btn-rm-b btn-block btn-lg"><i class="fas fa-registered"></i> ลงความเสี่ยง</a>
                </div>
                <div class="col-md-6">
                    <a href="" class=" btn btn-rm-o btn-block btn-lg"><i class="fas fa-tasks"></i> คู่มือการใช้งาน</a>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-md-12 text-center">
                    <h5 class=" text-danger">ระบบอยู่ในระหว่างการพัฒนาและปรับปรุง Version :<?php echo env("VERSION"); ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
