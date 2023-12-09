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

        .grid-container {
        display: grid;
        grid-template-columns: auto auto auto auto;
        grid-gap: 10px;
        background-color: #2196F3;
        padding: 10px;
        }
        .grid-container > div {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid black;
        text-align: center;
        font-size: 30px;
        }
    </style>
    <title>ใบรายงานความเสี่ยง</title>
</head>
<body>
@include('function.dathai')
<div>
    <img src="./img/<?php echo env("APP_LOGO_REPORT_FILENAME"); ?>" width="250px"></td>
    <hr>
</div>
<div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
        <td colspan="2" style="font-size: 21px;"><b>แหล่งข้อมูล :</b> {{$q->source->source_name}}</td>
        </tr>
        <tr>
        <td style="font-size: 21px;"><b>วันเวลาที่เกิดเหตุ :</b> {{DateThai($q->rmmain_dateon)}} {{$q->rmmain_time}} {{$q->rm_part_time}}</td>
            <td style="font-size: 21px;"><b>สถานที่เกิดเหตุ :</b>
                @if ($q->rm_point > 0)
                    {{$q->c_dep->dep_name}}
                @else
                    ไม่ได้ระบุ
                @endif
            </td>
        </tr>
        <tr>
            <td style="font-size: 21px;"><b>ผู้ได้รับผลกระทบ :</b>
                @if ($q->rm_affected_person == null || $q->rm_affected_person == "")
                    ไม่ได้ระบุ
                @elseif($q->rm_affected_person == 1)
                    {{$q->affected->affected_name}} เพศ : {{ $q->rm_affected_sex}} อายุ : {{ $q->rm_affected_age}}
                @elseif($q->rm_affected_person > 1)
                    {{$q->affected->affected_name}}
                @endif
            </td>
            <td style="font-size: 21px;"><b>ผลกระทบ :</b>
                @if ($q->effect_code > 0)
                    {{$q->effect->effect_name}}
                @endif
            </td>
        </tr>
        <tr>
            <td style="font-size: 21px;"><b>โรคเฉพาะ :</b>
                @if ($q->specd_code > 0)
                    {{$q->specd->specd_name}}
                @endif
            </td>
            <td style="font-size: 21px;"><b>ชนิดความเสี่ยง :</b>
                @if ($q->clinic_code > 0)
                    {{$q->c_clinic->clinic_name}}
                @endif
            </td>
        </tr>
        <tr>
        <td style="font-size: 21px;"><b>ผู้รายงาน :</b>
            @if ($qrp_c > 0)
                {{$qrp->person_fname}} {{$qrp->person_lname}}
            @else
                ไม่ได้ระบุ
            @endif
        </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>ระดับความรุนแรง :</b>
                @if ($q->level_code > 0 || $q->level_code != null)
                     {{$q->level->level_name}} : {{$q->level->level_detail}}
                @else

                @endif
            </td>
        </tr>
      </table>
      <hr>
      <table style="width:100%">
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>หัวข้อ : </b>
                @if ($q->rmmain_topic != "" || $q->rmmain_topic != null)
                    {{$q->rmmain_topic}}
                @else
                    ไม่ได้ระบุ
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>รายละเอียด : </b>
                @if ($q->rmmain_detail != "" || $q->rmmain_detail != null)
                    {{$q->rmmain_detail}}
                @else
                    ไม่ได้ระบุ
                @endif
            </td>
        </tr>
      </table>
      <hr>
      <table style="width:100%">
        <tr>
            <td style="font-size: 21px;"><b>วันที่ทบทวน : </b>
                @if ($q->rm_date_review !="" || $q->rm_date_review != null)
                    {{DateThai($q->rm_date_review)}}
                @endif
            </td>
            <td style="font-size: 21px;"><b>สถานะการทบทวน : </b>
                @if ($q->system_code !="" || $q->system_code != null)
                    {{$q->system->system_name}}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>การทบทวนทีม RM : </b>
                @if ($q->rm_results_review !="" || $q->rm_results_review != null)
                    {{$q->rm_results_review}}
                @endif
        </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>การทบทวนทีมนำ : </b>
                @if ($q->rm_results_leading_team !="" || $q->rm_results_leading_team != null)
                    {{$q->rm_results_leading_team}}
                @endif
        </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px;"><b>การทบทวนหน่วยงาน : </b>
                @if ($q->rm_results_dep_team !="" || $q->rm_results_dep_team != null)
                    {{$q->rm_results_dep_team}}
                @endif
        </td>
        </tr>
      </table>
      <hr>
      <table style="width:100%">
        <tr valign="top">
            <td valign="top" style="font-size: 21px;"><b>หน่วยงานที่เกี่ยวข้อง</b><br>
                @foreach ($q_dep_code as $r)
                    <span>{{$r->dep_name}}</span><br>
                @endforeach
            </td>
            <td valign="top" style="font-size: 21px;"><b>กรรมการที่เกี่ยวข้อง</b><br>
                @foreach ($q_committee_code as $r)
                    <span>{{$r->committee_name}}</span><br>
                @endforeach
            </td>
        </tr>
        <tr valign="top">
            <td valign="top" colspan="2" style="font-size: 21px;"><b>รหัสความเสี่ยง</b><br>
                @foreach ($q_risk_code as $r)
                    <span>{{$r->risk_name}}</span><br>
                @endforeach
            </td>
        </tr>
      </table>
      <hr>
      <div style="text-align: right">
        <h4><i>Risk_ic by Samitra</i> ปริ้นโดย {{$q_user->person_fname}} {{$q_user->person_lname}} {{$d_n}} {{$d_t}}</h4>
      </div>
</div>



</body>
</html>
