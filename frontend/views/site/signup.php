<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>


<h2>Выберите удобную социальную сеть</h2>
<p style="text-align: center;"><a href="/site/auth?authclient=vkontakte"><img src="/img/vk.png" /></a> <a href="/site/auth?authclient=facebook"><img src="/img/fb.png" /></a> <a href="/site/auth?authclient=twitter"><img src="/img/tw.png" /></a></p>

<h2>или заполните форму</h2>


            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

