<?php

namespace common\filters;

use Yii;
use yii\base\ActionFilter;

class GoBackFilter extends ActionFilter
{
    public $exclude = [];

    public function afterAction($action, $result)
    {
        if (!in_array($action->id, $this->exclude)) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        }
        return parent::afterAction($action, $result);
    }
}