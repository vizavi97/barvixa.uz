<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class Consumable extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_consumables';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $belongsTo = [
        'category' => ConsumablesCategories::class
    ];
}
