<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = 'Неполадки на сайте';
$this->params['breadcrumbs'][] = $this->title;
?>


<p>Дорогие организаторы и участники, мы стараемся делать сервис для вас ещё удобнее и интереснее, нам важна обратная связь.</p>
<p>Спасибо, будем вам очень благодарны!</p>


<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

<?= $form->field($model, 'link')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'defect')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>
