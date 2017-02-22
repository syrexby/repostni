
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
<h2 class="text-center login__sub-header">Выберите удобную социальную сеть для входа</h2>
<p style="text-align: center;"><a href="/site/auth?authclient=vkontakte"><img src="/img/vk.png" /></a> <a href="/site/auth?authclient=facebook"><img src="/img/fb.png" /></a> <a href="/site/auth?authclient=twitter"><img src="/img/tw.png" /></a></p>

