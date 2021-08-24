<?php namespace Tim\Vavilon\Models;

use Model;

/**
 * Model
 */
class Refs extends Model
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
    public $table = 'tim_vavilon_users_ref';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
