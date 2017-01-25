<?php

use common\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition/list"];
$this->params['breadcrumbs'][] = ["label" => $this->title, "url" => "/competition/view?id=" . $model->id];
$this->params['breadcrumbs'][] = 'Завершение конкурса';

?>

<?= $this->render("_blocks", ["model" => $model]) ?>
<?php
$time = strtotime($model->date);
?>
<h1 style="text-align: center;"><?= StringHelper::dec($model->getRightDays(true), ["Осталось", "Остался", "Осталось"]) ?> <strong><?= $model->getRightDays() ?></strong> до окончания конкурса</h1>

<div style="text-align: center">
    <p>Дата розыгрыша:
        <strong><?= date("d", $time) . " " . \common\helpers\Date::ruMonth(date("m", $time), 1) . " " . date("Y", $time) ?>
            , в <?= date("H:i", $time) ?></strong></p>
</div>
<?php
    $videoInfo = '<div class="video-info">
    <p>При розыгрыше конкурса рекомендуем снимать видео Вашего экрана, далее загрузить на YouTube и указать ниже ссылку на видео, это увеличивает доверие участников к розыгрышку.</p>
    <p>Для записи Вашего экрана мы рекомендуем программу <span class="ocam-icon"></span> <a href="/soft/oCam_v313.0.exe">oCam</a></p>
</div><div class="video-info-bg"></div><div id="video-frame"></div>';

    ?>

<?php $form = ActiveForm::begin(['id' => 'form-create', 'options' => ['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model, 'video_url', ['template' => '<div class="form-group">{label}' . $videoInfo . '{input}</div>'])->textInput(["placeholder" => "Ссылка на видео с youtube"]) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Завершить конкурс', ['class' => 'btn btn-success btn-lg', 'name' => 'create-button']) ?>
    </div>

<?php ActiveForm::end(); ?>