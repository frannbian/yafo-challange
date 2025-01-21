<?php

namespace App\Imports;

use App\Models\CMDB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CMDBImport implements ToModel, WithValidation, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $optionalsValues = [];
        $totalValues = count($row);
        for($i = 3; $i < $totalValues; $i++) {
            $optionalsValues[] = $row[$i];
        }

        return new CMDB([
            'identificator'     => $row[0],
            'name'    => $row[1],
            'category_id' => $row[2],
            'optional_values' => $optionalsValues
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
        ];
    }
}
