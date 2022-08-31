<?php

namespace App\Exports;

use App\Rmmain;
use App\Rmlistall;
use App\Rmlistdep;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RmExport implements FromQuery,WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function datestart(string $dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function dateend(string $dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function dep(string $dep)
    {
        $this->dep = $dep;

        return $this;
    }

    public function query()
    {
        if($this->dep === "0"){
            return  Rmlistall::query()->select('rmmain_id','rmmain_dateon','rmmain_time','rmdepname','rmmain_topic','rmmain_detail','rmlevel','clinic_name','fullname','system_name','created_at')
                                    ->whereBetween('rmmain_daterp', [$this->dateStart, $this->dateEnd])
                                    ->orderBy('rmmain_daterp', 'asc')
                                    ->limit(9999);
        }else{
            return  Rmlistdep::query()->select('rmmain_id','rmmain_dateon','rmmain_time','rmdepname','rmmain_topic','rmmain_detail','rmlevel','clinic_name','fullname','system_name','created_at')
                                    ->whereBetween('rmmain_daterp', [$this->dateStart, $this->dateEnd])
                                    ->where('rmdepcode',$this->dep)
                                    ->orderBy('rmmain_daterp', 'asc')
                                    ->limit(9999);
        }
    }

    public function headings(): array
    {
        return [
            '#CODE',
            'วันที่เกิดเหตุ',
            'เวลาที่เกิดเหตุ',
            'หน่วยงานที่เกี่ยวข้อง',
            'เรื่องความเสี่ยง',
            'รายละเอียดความเสี่ยง',
            'ระดับความเสี่ยง',
            'ประเภท',
            'ชื่อผู้แจ้ง',
            'การทบทวน',
            'วันที่ลงข้อมูล'
        ];
    }
}
