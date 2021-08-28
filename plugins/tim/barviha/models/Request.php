<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class Request extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_requests';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function products() {
        return $this->hasMany(RequestProducts::class, 'request_id');
    }
}
