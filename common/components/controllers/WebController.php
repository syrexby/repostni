<?php

namespace common\components\controllers;

use common\filters\GoBackFilter;
use Yii;
use yii\web\Controller;

class WebController extends Controller
{
    public function behaviors()
    {
        return [
            'goBack' => [
                'class' => GoBackFilter::className(),
                'exclude' => ["login", "logout"],
            ]
        ];
    }
}