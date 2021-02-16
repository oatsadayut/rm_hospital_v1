@extends('layouts.app')
@section('content')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ผู้มีสิทธิ์ใช้งานระบบ > อนุมัติผู้ใช้</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                        <form method="POST" action="{{ route('user-submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 pt-5 px-5">
                                    <h5>อนุมัติรายการนี้</h5>
                                    <hr>
                                    <h5 class=" bg-info p-2">[{{$q->cid}}] {{$q->person_fname}} {{$q->person_lname}}</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="permission" class=" h5">สิทธิ์การใช้งาน</label>
                                        <select id="sel-25" name="permission" class="form-control" required>
                                            @foreach ($permission as $rp)
                                                <option value="{{$rp->per_id}}">{{$rp->per_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 py-2">
                                    <input type="hidden" name="user_id" value="{{$q->id}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/user" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
