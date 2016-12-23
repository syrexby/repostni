<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = 'Предложения и пожелания';
$this->params['breadcrumbs'][] = $this->title;
?>


<p>Дорогие организаторы и участники, мы стараемся делать сервис для вас ещё удобнее и интереснее, нам важна обратная связь.</p>
<p>Если у вас есть идеи, предложения и пожелания по улучшению сервиса, будем рады выслушать их, а если идея будет еще интересной и полезной, то вкусные плюшки гарантированы. Чтобы написать нам свои предложения и пожелания, воспользуйтесь формой ниже.</p>


<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

<?= $form->field($model, 'name')->label("Ваше имя (не обязательно)")->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'phone_or_email')->label("Почта или мобильный номер (не обязательно)") ?>

<?= $form->field($model, 'feedback')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>
