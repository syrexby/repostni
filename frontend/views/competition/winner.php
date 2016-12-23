<?php

use common\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition"];
$this->params['breadcrumbs'][] = ["label" => $this->title, "url" => "/competition/view?id=" . $model->id];
$this->params['breadcrumbs'][] = 'Выбор победителя конкурса';

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

<div class="members-list">
    <?php
    foreach (\common\models\CompetitionPrize::find()->where(["competition_id" => $model->id])->orderBy("position")->all() as $prize) {
    $winner = $prize->getWinner();
        ?>
    <div class="item item-big">
        <div class="item-position"><strong><?= $prize->position ?></strong> место</div>
        <div class="member-block" id="winner-block-<?= $prize->id ?>">
            <?php if ($winner) { ?>
            <strong><?= $winner->user->name ?></strong>
            <br>
            <div class="member-detail">
                <?= $winner->user->country ? '<span class="country"><img src="/img/map.png"></span> '.$winner->user->country->name.' <span class="delimiter"> | </span>' : '' ?>
                <a href="<?= $winner->user->getProfileUrl() ?>" target="_blank"><?= \yii\helpers\StringHelper::truncate($winner->user->getProfileUrl(), 35) ?></a>
            </div>
            <?php } ?>
        </div>
        <div class="options">
            <a href="#" class="winner-btn <?= $winner ? '' : 'green' ?>" data-id="<?= $prize->id ?>"><i class="fa fa-refresh" aria-hidden="true"></i> <?= $winner ? 'Переизбрать' : 'Выбрать' ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php } ?>
</div>

<div style="text-align: center; padding: 10px 0 0;">
    <?php
    Modal::begin([
        'header' => '',
        'toggleButton' => [
            'tag' => 'a',
            'class' => 'btn btn-lg btn-success',
            'label' => 'Завершить конкурс',
        ],
    ]);
    ?>
    <?php $form = ActiveForm::begin(['id' => 'form-close', 'action' => '/competition/close?id=' . $model->id]); ?>
    <div id="video-frame"></div>

    <?= $form->field($model, 'video_url')->textInput(["value" => "", "placeholder" => "Ссылка на видео с youtube"])->label("Ваше видео розыгрыша конкурса (необязательно)") ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Завершить конкурс', ['class' => 'btn btn-success btn-lg', 'name' => 'create-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    Modal::end();
    ?>
</div>