<?php

namespace App\Exports;

use App\Rmmain;
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
            return  Rmmain::query()->select('rmmain.rmmain_id','rmmain.rmmain_dateon','rmmain.rmmain_time','co_dep.dep_name','rmmain.rmmain_topic','rmmain.rmmain_detail','co_level.level_name','co_level.level_detail','person.person_fname','person.person_lname','rmmain.created_at')
                                    ->join('co_dep', 'co_dep.dep_code', '=', 'rmmain.rmmain_deprp')
                                    ->join('co_level', 'co_level.level_code', '=', 'rmmain.level_code')
                                    ->join('person', 'person.person_cid', '=', 'rmmain.rmmain_cidrp')
                                    ->whereBetween('rmmain.rmmain_daterp', [$this->dateStart, $this->dateEnd])
                                    ->where('rmmain.status','Y')
                                    ->orderByDesc('rmmain.rmmain_id')
                                    ->limit(9999);
        }else{
            return  Rmmain::query()->select('rmmain.rmmain_id','rmmain.rmmain_dateon','rmmain.rmmain_time','co_dep.dep_name','rmmain.rmmain_topic','rmmain.rmmain_detail','co_level.level_name','co_level.level_detail','person.person_fname','person.person_lname','rmmain.created_at')
                                    ->join('co_dep', 'co_dep.dep_code', '=', 'rmmain.rmmain_deprp')
                                    ->join('co_level', 'co_level.level_code', '=', 'rmmain.level_code')
                                    ->join('person', 'person.person_cid', '=', 'rmmain.rmmain_cidrp')
                                    ->whereBetween('rmmain.rmmain_daterp', [$this->dateStart, $this->dateEnd])
                                    ->where('rmmain.rmmain_deprp',$this->dep)
                                    ->where('rmmain.status','Y')
                                    ->orderByDesc('rmmain.rmmain_id')
                                    ->limit(9999);
        }
    }

    public function headings(): array
    {
        return [
            '#CODE',
            'วันที่เกิดเหตุ',
            'เวลาที่เกิดเหตุ',
            'หน่วยงานที่แจ้งความเสี่ยง',
            'หัวข้อมเรื่องความเสี่ยง',
            'รายละเอียดความเสี่ยง',
            'ระดับความเสี่ยง',
            'รายละเอียดระดับความเสี่ยง',
            'ชื่อผู้แจ้ง',
            'นามสกุลผู้แจ้ง',
            'วันที่ลงข้อมูล'
        ];
    }

}
