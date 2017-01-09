<?php
/* @var common\models\Competition $model */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
?>
<div class="winner">
    <div class="winner-cup col-md-4">
        <img src="//repostni.com/img/cup.png" alt="">
    </div>
    <div class="winner-header col-md-8">
        <p class="winner-p1"><?= $this->title?></p>
        <p class="winner-p2">Конкурс завершен</p>
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
                <div class="clearfix"></div>
            </div>
        <?php } ?>
    </div>
    <?php if(!$model->videoUrlFinal()) {?>
    <div class="video-final">
        <?php
        //var_dump($model->video_url); die();
        Modal::begin([
            'header' => '',
            'toggleButton' => [
                'tag' => 'a',
                'class' => 'btn btn-lg btn-addvideo',
                'label' => 'Добавить видеоотчет',
            ],
        ]);
        ?>
        <?php $form = ActiveForm::begin(['id' => 'form-close', 'action' => '/competition/close?id=' . $model->id]); ?>
        <div id="video-frame"></div>

        <?= $form->field($model, 'video_url_final')->textInput(["value" => "", "placeholder" => "Ссылка на видео с youtube"])->label("Ваше видео розыгрыша конкурса (необязательно)") ?>

        <div class="form-group" style="text-align: center;">
            <?= Html::submitButton('Сохранить видео', ['class' => 'btn btn-success btn-lg', 'name' => 'create-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <?php
        Modal::end();
        ?>
    </div>
    <?php } else{ ?>
    <div class="video-final">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $model->videoUrlFinal() ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php } ?>
    <div style="background-color: #fbfcaf;">
        <div style="width:380px; padding: 18px 0 18px 25px; float: left">
            <p style="font-size: 24px; color:black; font-weight: bold;">Благодарим всех за участие!</p>
            <p style="font-size: 16px; color: #898989;">Организатор конкурса свяжется с победителем для вручения приза</p>
        </div>
        <div style="background: url('//repostni.com/img/star.png') no-repeat; width: 190px; height:133px; float: right;">
        </div>
        <div class="clearfix"></div>
    </div>
    
</div>
