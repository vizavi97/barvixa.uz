<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'preview_img' => 'System\Models\File',
    ];

    public $belongsTo = [
        'category' => ProductCategories::class
    ];
}
