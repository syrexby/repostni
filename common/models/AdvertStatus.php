<?php

namespace common\models;

use Yii;
use \common\models\base\AdvertStatus as BaseAdvertStatus;

/**
 * This is the model class for table "advert_status".
 */
class AdvertStatus extends BaseAdvertStatus
{
    const STATUS_WAIT = 1;
    const STATUS_ACTIVE = 3;
}
