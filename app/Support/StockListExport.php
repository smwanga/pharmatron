<?php

namespace App\Support;

use Maatwebsite\Excel\Files\NewExcelFile;

class StockListExport extends NewExcelFile
{
    public function getFilename()
    {
        return 'Import Stock Data From File';
    }
}
