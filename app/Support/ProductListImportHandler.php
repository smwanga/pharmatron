<?php

namespace App\Support;

use App\Entities\Category;
use Maatwebsite\Excel\Files\ImportHandler;
use App\Contracts\Repositories\ProductRepository as Repository;

class ProductListImportHandler implements ImportHandler
{
    /**
     * Validation error bag.
     *
     * @var array
     */
    protected $validationErrors = [];

    /**
     * The total number of products in the file.
     *
     * @var int
     **/
    public $productCount = 0;

    /**
     * The total number of products that were successfully import.
     *
     * @var int
     **/
    public $importedCount = 0;

    /**
     * Handle the import of products from an excel file.
     *
     * @param ProductListImport $file
     *
     * @return array
     */
    public function handle($file)
    {
        $repository = app(Repository::class);
        $file->each(function ($sheet) use ($repository) {
            return $sheet->filter(function ($row) {
                ++$this->productCount;

                return $this->validate($row->toarray());
            })->map(function ($product) use ($repository) {
                $repository->create($product->toarray());
                ++$this->importedCount;
            });
        });

        return $this;
    }

    /**
     * Validate the uploaded data.
     *
     * @param array $data
     *
     * @return bool
     **/
    protected function validate(array $data)
    {
        $units = Category::whereGroup('dispense_unit')->pluck('category')->toarray();
        $data = collect($data)->map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        })->all();
        $rules = [
            'item_name' => 'required',
            'generic_name' => 'nullable',
            'stock_code' => 'required|unique:products',
            'barcode' => 'nullable|numeric|unique:products',
            'dispensing_unit' => 'required|in:'.join(',', $units),
            'alert_level' => 'nullable|numeric|min:0',
            'instructions' => 'required|string',
        ];
        $validator = app()->validator->make($data, $rules, ['generic_name.required_if' => 'This field is required when the item name is not specified']);
        if ($validator->fails()) {
            $this->validationErrors[str_slug($data['item_name'])] = $validator->errors()->all();

            return false;
        }

        return true;
    }

    /**
     * Get the validation errors encountered during import.
     *
     * @return array
     **/
    public function errors()
    {
        return $this->validationErrors;
    }
}
