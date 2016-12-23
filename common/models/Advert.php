<?php

namespace common\models;

use Yii;
use \common\models\base\Advert as BaseAdvert;

/**
 * This is the model class for table "advert".
 */
class Advert extends BaseAdvert
{
    public $x1;
    public $y1;
    public $x2;
    public $y2;

    const DEFAULT_STATUS = 1;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "string", "max" => 25],
            [["x1", "x2", "y1", "y2"], "safe"],
            ["description", "string", "max" => 50],
            ["url", "url", 'defaultScheme' => 'http'],
            [["name", "description", "url", "photo_file_id"], "required"]
        ]);
    }
}
