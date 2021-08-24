<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class Test extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_test';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
