<?php namespace Tim\Barviha\Models;

use Model;

/**
 * Model
 */
class Hall extends Model {
    use \October\Rain\Database\Traits\Validation;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tim_barviha_halls';

    public $attachOne = [
        'preview_img' => 'System\Models\File',
    ];


    /**
     * @var array Validation rules
     */
    public $rules = [
    ];


//    public function getPreviewImgAttribute()
//    {
//////        try {
//////            $item = $this->with('preview_img')->find($this->id);
//////            dump($item->preview_img->getPath());
//////        } catch (\Exception $e) {
//////            dump($e);
//////        }
////        return "<img src='https://barvixa.uz/themes/vavilon-front/assets/images/landing/banner-device.svg'/>";
//        return '<img src="https://barvixa.uz/themes/vavilon-front/assets/images/landing/banner-device.svg" />';;
//    }
}
