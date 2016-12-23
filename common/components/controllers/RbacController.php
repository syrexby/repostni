<?php

namespace common\components\controllers;

use common\filters\RbacControlFilter;

class RbacController extends WebController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => RbacControlFilter::className(),
            ]
        ]);
    }
}