<?php

namespace App\Support;

use Maatwebsite\Excel\Files\ExcelFile;

class ProductListImport extends ExcelFile
{
    public function getFile()
    {
        return request()->file('importedFile');
    }

    public function getFilters()
    {
        return [
            'chunk',
        ];
    }
}
