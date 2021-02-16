<div class=" row">
    <div class="col-md-6">
        <h5>ตั้งค่ารหัสความเสี่ยง</h5>
    </div>
    <div class="col-md-6 text-right">
        <a href="/rmcode/manage/riskcode" class=" btn btn-warning btn-sm text-dark"><i class="fas fa-tasks"></i> จัดการข้อมูล</a>
    </div>
</div>

<hr>
<div>
    <table id="tebal-setting7" class="table table-sm table-hover">
        <thead class="thead-light ">
          <tr>
            <th scope="col">รหัส</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">Mapping code</th>
            <th scope="col">สถานะ</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($riskcode as $r)
                <tr>
                    <th scope="row">{{$r->risk_code}}</th>
                    <td>{{$r->risk_name}}</td>
                    <td>{{$r->export_code}}</td>
                    <td>
                        @if ($r->status != '' || $r->status != null)
                            @if ($r->status == 'Y')
                            <span class="badge badge-success">{{$r->status}} ใช้งาน</span>
                            @else
                            <span class="badge badge-danger">{{$r->status}} ยกเลิก</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
</div>
