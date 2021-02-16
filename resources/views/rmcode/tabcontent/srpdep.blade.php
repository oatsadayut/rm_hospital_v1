<div class=" row">
    <div class="col-md-6">
        <h5>รหัสส่งออก หน่วยงาน</h5>
    </div>
    <div class="col-md-6 text-right">
        <a href="/rmcode/manage/srpdep" class=" btn btn-warning btn-sm text-dark"><i class="fas fa-tasks"></i> จัดการข้อมูล</a>
    </div>
</div>
<hr>
<div>
    <table id="tebal-setting19" class="table table-sm table-hover">
        <thead class="thead-light ">
          <tr>
            <th scope="col">รหัส</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">Export code</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($dep_srp as $r)
                <tr>
                    <th scope="row">{{$r->dep_srp_id}}</th>
                    <td>{{$r->dep_srp_name}}</td>
                    <td>{{$r->dep_srp_export_code}}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
</div>
