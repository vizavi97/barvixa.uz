<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class ProductConsumble extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_product_consumbles';

    public $belongsTo = [
        'product' => Product::class,
        'consumable' => Consumable::class
    ];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
