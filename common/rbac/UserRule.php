<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class UserRule extends Rule
{
    public $name = 'user';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            return true;
        }
        return false;
    }
}
