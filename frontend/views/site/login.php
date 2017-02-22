
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход для организаторов';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 style="text-align: center"><?= $this->title?></h1>
<h2 class="text-center">Выберите удобную социальную сеть</h2>
<p style="text-align: center;"><a href="/site/auth?authclient=vkontakte"><img src="/img/vk.png" /></a> <a href="/site/auth?authclient=facebook"><img src="/img/fb.png" /></a> <a href="/site/auth?authclient=twitter"><img src="/img/tw.png" /></a></p>

<h2 class="text-center">или заполните форму</h2>



            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

<div style="color:#999;margin:1em 0">
    Если Вы еще не зарегистрированы, то <?= Html::a('перейдите к регистрации', ['signup']) ?>.
</div>
<div style="color:#999;margin:1em 0">
                    Если Вы забыли пароль, его можно <?= Html::a('восстановить', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>

             <?php ActiveForm::end(); ?> 
