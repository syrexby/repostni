<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Размещение рекламы';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title?></h1>
<div class="row">
    <div class="col-md-7">


        <?php $form = ActiveForm::begin(['id' => 'form-create', 'options' => ['enctype' => 'multipart/form-data']]); ?>


        <?= $form->field($model, 'photo_file_id')->hiddenInput()->label("") ?>

        <div class="form-group field-advert-image">
            <div class="form-group"><label class="control-label" id="label-advert-image">Фото</label>
                <div id="image-upload-error"></div>
                <div id="image-upload" class="dropzone" style="text-align: center;" data-model="post"></div>
                <div id="image-crop-layer">
                    <div id="image-crop"></div>
                    <div style="text-align: center;padding-top:10px;">
                        <a href="#" class="btn btn-success" id="save-crop">Сохранить изображение</a> <a href="#" id="cancel-upload-image" class="btn btn-default">Отмена</a></div>
                </div>
            </div>
        </div>

        <?= $form->field($model, 'name', ['template' => '<div class="form-group">{label}{input}<p class="text-muted" id="help-text-name">Осталось: 25 символов</p></div>'])->textInput(['maxlength' => 25])->label("Заголовок") ?>

        <?= $form->field($model, 'description', ['template' => '<div class="form-group">{label}{input}<p class="text-muted" id="help-text-description">Осталось: 50 символов</p></div>'])->textarea(['maxlength' => 50]) ?>

        <?= $form->field($model, 'url')->textInput()->label("Ссылка на Ваш конкурс (сайт, канал youtube, группа в ВК)") ?>

        <div class="form-group">
            <p style="font-size: 18px; font-weight: bold;">Сумма к оплате 1 грн <img style="margin: -5px 0 0 50px;" src="/img/paysystem.png" /></p>
            <p class="text-muted">При оплате другой валютой сумма будет переконвертирована по курсу банка</p>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Перейти к оплате', ['class' => 'btn btn-success', 'name' => 'create-button']) ?>
        </div>
        <p class="text-muted">Реклама порнографического характера будет удаляться</p>
        <?php ActiveForm::end(); ?>


    </div>
    <div class="col-md-4">
        <h3 style="text-align: left;">Предпросмотр</h3>
        <div id="image-after-crop">
            <div id="delete-crop-image"><i class="fa fa-times" aria-hidden="true"></i></div>
            <img/>
        </div>
        <div id="post-preview" style="width: 220px;word-wrap: break-word;">
            <img src="/img/blank.png" width="220" height="127">
                <h4 style="font-size: 17px; font-weight: bold;">Заголовок</h4>
                <p style="text-align: left;">Короткое описание</p>
        </div>
    </div>
</div>
