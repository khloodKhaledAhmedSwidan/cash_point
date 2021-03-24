<?php

namespace App\Imports;

use App\City;
use Maatwebsite\Excel\Concerns\ToModel;

class CitiesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new City([
            'cityId'    => $row[0],
            'name'      => $row[1],
            'nameAr'    => $row[2],
            'regionId'  => $row[3],
        ]);
    }
}
