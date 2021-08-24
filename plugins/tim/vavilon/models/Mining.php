<?php namespace Tim\Vavilon\Models;

use Model;

/**
 * Model
 */
class Mining extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_vavilon_mining';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'preview_img' => 'System\Models\File',
    ];

}
