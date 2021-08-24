<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class ProductCategories extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_product_categories';

		
    public $attachOne = [
        'preview_img' => 'System\Models\File',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
