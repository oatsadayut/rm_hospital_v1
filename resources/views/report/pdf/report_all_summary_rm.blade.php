<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";

        }
        .head{
            margin-left: 19rem;
            margin-bottom: 0px;
        }
        .report-name{
            margin-left: 12rem;
            margin-bottom: 0px;
        }
        .report-date{
            margin-left: -0.5rem;
            margin-bottom: 0px;
        }
        .row-w{
            width: 150px;
        }
    </style>
<title>ภาพรวมความเสี่ยง โรงพยาบาล</title>
</head>
<body>
@include('function.dathai')
<div class="head">
    <img src="./img/logo_2.jpg" width="80px"></td>
</div>
<div>
    <h2 class="report-name">รายงานภาพรวมความเสี่ยง ระดับโรงพยาบาล <br><small class="report-date">ช่วงวันที่ : {{DateThai($date_start)}} ถึง {{DateThai($date_end)}}</small></h2>

</div>
<hr>
<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="font-size: 25px;"><b>ความเสี่ยงทั้งหมด : {{$q_rm}} ครั้ง</b></td>
            <td style="font-size: 25px;"><b>ทบทวนแล้ว : {{$q_rm_check}} ครั้ง</b></td>
            <td style="font-size: 25px;"><b>ยังไม่ทบทวน : {{$q_rm_uncheck}} ครั้ง</b></td>
        </tr>
    </table>
    <hr>
</div>

<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table>
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">ช่วงเวรที่เกิดความเสี่ยง</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>เวรเช้า</b></td>
                            <td><b>{{$q_rm_time_1}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>เวรบ่าย</b></td>
                            <td><b>{{$q_rm_time_2}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>เวรดึก</b></td>
                            <td><b>{{$q_rm_time_3}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td style="vertical-align: top;">
                <table >
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">ชนิดความเสี่ยง</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>Clinical Risk :</b></td>
                            <td><b>{{$q_clinic_1}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>Non Clinical Risk :</b></td>
                            <td><b>{{$q_clinic_2}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ไม่ระบุ :</b></td>
                            <td><b>{{$q_clinic_3}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td style="vertical-align: top;">
                <table >
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">ผู้ที่ได้รับผลกระทบ</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>บุคคล</b></td>
                            <td><b>{{$q_affected_1}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>กลุ่มบุคคล</b></td>
                            <td><b>{{$q_affected_2}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>หน่วยงาน</b></td>
                            <td><b>{{$q_affected_3}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>

<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table>
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">กรรมการที่เกี่ยวข้อง</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>PCT Clinic :</b></td>
                            <td><b>{{$q_committee_PCT}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>PTC เภสัช :</b></td>
                            <td><b>{{$q_committee_PTC}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>IC :</b></td>
                            <td><b>{{$q_committee_IC}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ENV :</b></td>
                            <td><b>{{$q_committee_ENV}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>EQU :</b></td>
                            <td><b>{{$q_committee_EQU}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>IM :</b></td>
                            <td><b>{{$q_committee_IM}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>HRD :</b></td>
                            <td><b>{{$q_committee_HRD}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>RM :</b></td>
                            <td><b>{{$q_committee_RM}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ไม่ระบุ :</b></td>
                            <td><b>{{$q_committee_null}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td style="vertical-align: top;">
                <table >
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">แหล่งข้อมูล</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>ทะเบียนความบันทึกความเสี่ยง</b></td>
                            <td><b>{{$q_source_1}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ข้อร้องเรียน ข้อคิดเห็น</b></td>
                            <td><b>{{$q_source_2}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ทบทวน 12 กิจกรรม</b></td>
                            <td><b>{{$q_source_3}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ทบทวน trigger tool</b></td>
                            <td><b>{{$q_source_4}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>เหตุการณ์สำคัญ</b></td>
                            <td><b>{{$q_source_5}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>Round</b></td>
                            <td><b>{{$q_source_6}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ใบซ่อมบำรุง</b></td>
                            <td><b>{{$q_source_7}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ทบทวน Re-Admit 28 วัน</b></td>
                            <td><b>{{$q_source_8}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td style="vertical-align: top;">
                <table >
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">ผลกระทบ</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        <tr>
                            <td><b>AE Error</b></td>
                            <td><b>{{$q_effect_1}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>AE</b></td>
                            <td><b>{{$q_effect_2}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>Error</b></td>
                            <td><b>{{$q_effect_3}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>Error Alert*</b></td>
                            <td><b>{{$q_effect_4}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>Sentinel Event*</b></td>
                            <td><b>{{$q_effect_5}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ไม่ระบุ</b></td>
                            <td><b>{{$q_effect_6}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>

        </tr>
    </table>
    <hr>
</div>

<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table style="width:100%;">
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="3" scope="col">ระดับความรุนแรง</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 19px;">
                        <tr>
                            <td><b>ระดับ A : {{$q_level_1}} ครั้ง</b></td>
                            <td><b>ระดับ G : {{$q_level_7}} ครั้ง</b></td>
                            <td><b>ระดับ4 การฟ้องร้อง : {{$q_level_19}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ระดับ B : {{$q_level_2}} ครั้ง</b></td>
                            <td><b>ระดับ H : {{$q_level_8}} ครั้ง</b></td>
                            <td><b>ระดับ1 NonClinic Near Miss : {{$q_level_10}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ระดับ C : {{$q_level_3}} ครั้ง</b></td>
                            <td><b>ระดับ I : {{$q_level_9}} ครั้ง</b></td>
                            <td><b>ระดับ2 NonClinic Miss 1 หมื่น : {{$q_level_11}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ระดับ D : {{$q_level_4}} ครั้ง</b></td>
                            <td><b>ระดับ1 ข้อคิดเห็น/ข้อเสนอแนะ : {{$q_level_10}} ครั้ง</b></td>
                            <td><b>ระดับ3 NonClinic Miss 1หมื่น-1แสน : {{$q_level_12}} ครั้ง</b></td>
                        </tr>
                        <tr>
                            <td><b>ระดับ E : {{$q_level_5}} ครั้ง</b></td>
                            <td><b>ระดับ2 ข้อร้องเรียนเรื่องเล็ก : {{$q_level_11}} ครั้ง</b></td>
                            <td><b>ระดับ4 NonClinic Miss > 1 แสน : {{$q_level_13}} ครั้ง</b></td>
                        </tr>
                        <tr >
                            <td><b>ระดับ F : {{$q_level_6}} ครั้ง</b></td>
                            <td><b>ระดับ3 ข้อร้องเรียนเรื่องใหญ่ : {{$q_level_12}} ครั้ง</b></td>
                            <td><b>ไม่ระบุ : {{$q_level_14}} ครั้ง</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>



<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table style="width:100%;">
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">TOP 5 รหัสความเสี่ยงที่พบบ่อย (Clinical)</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        @foreach ($q_top5_riskcode_1 as $r)
                        <tr>
                            <td><b>{{$r->risk_name}}</b></td>
                            <td><b>{{$r->count}} ครั้ง</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>

<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table style="width:100%;">
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">TOP 5 รหัสความเสี่ยงที่พบบ่อย (Non Clinical)</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        @foreach ($q_top5_riskcode_2 as $r)
                        <tr>
                            <td><b>{{$r->risk_name}}</b></td>
                            <td><b>{{$r->count}} ครั้ง</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>

<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top;">
                <table style="width:100%;">
                    <thead style="font-size: 25px;">
                      <tr>
                        <th colspan="2" scope="col">หน่วยงานที่รายงานความเสี่ยง <br><span style="font-size: 18px;">**รายงานจับจากสังกัดของผู้ที่รายงานความเสี่ยง</span> <hr></th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 21px;">
                        @foreach ($q_person_report as $r)
                        <tr>
                            <td><b>{{$r->dep_name}} ({{$r->dep_ename}})</b></td>
                            <td><b>{{$r->count}} ครั้ง</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>

<div style="text-align: right">
    <h4><i>Risk_ic by Samitra</i> ปริ้นโดย {{$q_user->person_fname}} {{$q_user->person_lname}} {{$d_n}} {{$d_t}}</h4>
</div>
</body>
</html>
