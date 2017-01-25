<?php

use common\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition/list"];
$this->params['breadcrumbs'][] = ["label" => $this->title, "url" => "/competition/view?id=" . $model->id];
$this->params['breadcrumbs'][] = 'Выбор победителя конкурса';

?>


<?php
$time = strtotime($model->date);
?>
<div class="winner">
<div class="winner-cup col-md-4">
    <img src="//repostni.com/img/cup.png" alt="">
</div>
<div class="winner-header col-md-8">
    <p class="winner-p1"><?= $this->title?></p>
    <p class="winner-p2">Выбор победителя</p>
</div>
<div class="members-list">
    <?php
    foreach (\common\models\CompetitionPrize::find()->where(["competition_id" => $model->id])->orderBy("position")->all() as $prize) {
    $winner = $prize->getWinner();
        ?>
    <div class="item item-big">
        <div class="item-position"><strong><?= $prize->position ?></strong> место</div>
        <div class="member-block" id="winner-block-<?= $prize->id ?>">
            <?php if ($winner) { ?>
            <div style="float: left;">
            <strong><?= $winner->user->name ?></strong>
            </div>
            <div class="member-detail" style="float: left;">
                <?= '<span class="delimiter"> </span>'  ?>
                <a href="<?= $winner->user->getProfileUrl() ?>" target="_blank"><i class="glyphicon glyphicon-link"></i>Ссылка</a>
            </div>
            <?php } ?>
        </div>
        <div class="options">
            <a href="#" class="winner-btn <?= $winner ? '' : '' ?>" data-id="<?= $prize->id ?>"><?= $winner ? '<div class="winner-btn-1"><i class="glyphicon glyphicon-repeat"></i> Перевыбрать</div>' : '<div class="winner-btn-2">Выбрать победителя</div>' ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php } ?>
</div>

<div style="text-align: center; padding: 40px 0 0;">
    <?php $form = ActiveForm::begin(['id' => 'form-close', 'action' => '/competition/close?id=' . $model->id]); ?>
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Завершить конкурс', ['class' => 'btn btn-success btn-lg', 'name' => 'create-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>