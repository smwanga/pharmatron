<?php

namespace App\Support;

use Maatwebsite\Excel\Files\ExportHandler;

class ProductListExportHandler implements ExportHandler
{
    public function handle($file)
    {
        // work on the export
        return $file->sheet(
                    trans('main.products'),
                    function ($sheet) {
                        $sheet->fromArray(
                            [
                                [
                                    'Item Name' => '',
                                    'Generic Name' => '',
                                    'Stock Code' => '',
                                    'Barcode' => '',
                                    'Dispensing Unit' => '',
                                    'Alert Level' => '',
                                    'Description' => '',
                                    'Instructions' => '',
                                ],
                            ]
                        );
                        $sheet->setStyle([
                            'font' => [
                                'name' => 'Lato',
                                'size' => 14,
                                'bold' => true,
                            ],
                        ]);
                        $sheet->freezeFirstRow();
                    }
        )->download('xlsx');
    }
}
