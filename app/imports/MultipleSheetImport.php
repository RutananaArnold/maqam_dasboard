<?php


namespace App\imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            new SingleSheetImport()
        ];
    }
}

