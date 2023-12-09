<p>รายการความเสี่ยง ข้อมูลระหว่างวันที่: {{$date_first}} ถึง {{$date_last}} หน่วยบริการ: <?php echo env("APP_TITLE"); ?></p>
<p></p>
<table>
    <thead>
        <tr>
            <th>#CODE</th>
            <th>วันที่เกิดเหตุ</th>
            <th>เวลาที่เกิดเหตุ</th>
            <th>หน่วยงานที่เกี่ยวข้อง</th>
            <th>เรื่องความเสี่ยง</th>
            <th>รายละเอียดความเสี่ยง</th>
            <th>ระดับความเสี่ยง</th>
            <th>ประเภท</th>
            <th>ชื่อผู้แจ้ง</th>
            <th>การทบทวน</th>
            <th>กรรมการที่เกี่ยวข้อง</th>
            <th>วันที่ลงข้อมูล</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($q as $r)
            <tr>
                <td>{{ $r->rmmain_id }}</td>
                <td>{{ $r->rmmain_dateon }}</td>
                <td>{{ $r->rmmain_time }}</td>
                <td>{{ $r->rmdepname }}</td>
                <td>{{ $r->rmmain_topic }}</td>
                <td>{{ $r->rmmain_detail }}</td>
                <td>{{ $r->rmlevel }}</td>
                <td>{{ $r->clinic_name }}</td>
                <td>{{ $r->fullname }}</td>
                <td>{{ $r->system_name }}</td>
                <td>{{ $r->rmcommitteename }}</td>
                <td>{{ $r->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
