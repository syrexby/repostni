<?php

namespace frontend\controllers;

use common\models\File;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class FileController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionUpload()
    {
        $model = new File();
        if ($model->load($_POST) && $model->validate()) {

            $model->uploadFile = UploadedFile::getInstance($model, "uploadFile");
            if ($model->upload()) {
                return Json::encode(["code" => 0, "result" => ["id" => $model->id, "url" => $model->getUrl(500, 500, true)]]);
            }
        }

        return Json::encode(["code" => 1, "errors" => $model->getErrors()]);

    }

}