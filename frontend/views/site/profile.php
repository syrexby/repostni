<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
<?= $form->errorSummary($model) ?>
<?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'user-button']) ?>
</div>

<?php ActiveForm::end(); ?>
