<?php

namespace App\Imports;

use App\ExcelStudentData;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExcelStudentData([
            'national_id'    => $row[0],
            'name'           => $row[1],
        ]);
    }
}
