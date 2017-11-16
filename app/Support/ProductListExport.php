<?php

namespace App\Support;

use Maatwebsite\Excel\Files\NewExcelFile;

class ProductListExport extends NewExcelFile
{
    public function getFilename()
    {
        return 'Import Products From Excel';
    }
}
