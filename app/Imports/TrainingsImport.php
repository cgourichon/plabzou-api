<?php

namespace App\Imports;

use App\Models\Training;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrainingsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Training([
            'name' => $row['formation'],
            'duration' => $row['duree']
        ]);
    }
}
