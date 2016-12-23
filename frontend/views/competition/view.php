<?php

/** @var \common\models\Competition $model */
/* @var $this yii\web\View */

use common\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ListView;

$model->name = \yii\helpers\StringHelper::truncate($model->name, 50);

$this->title = $model->name;
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition"];
$this->params['breadcrumbs'][] = $this->title;
$dataImage = $model->photoFile ? $model->photoFile->getUrl(600, 600) : '';
$model->description = nl2br(stripslashes($model->description));
$model->description = preg_replace('#(?<!\])\bhttp://[^\s\[<]+#i',
    "<a href=\"$0\" target=_blank>$0</a>",
    $model->description);
$model->description = preg_replace('#(?<!\])\bhttps://[^\s\[<]+#i',
    "<a href=\"$0\" target=_blank>$0</a>",
    $model->description);
?>




<?php if ($model->open) { ?>
    <div>
        <div style="float: left; padding: 1px 10px 0 0;">Поделиться:</div>
        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script>
        <div class="ya-share2" style="float: left;" data-services="vkontakte,facebook,odnoklassniki,twitter"
             data-counter="" data-image="<?= $dataImage ?>" data-description="<?= \yii\helpers\StringHelper::truncate(Html::encode($model->description), 200) ?>"></div>
    </div>
    <div class="clearfix"></div>
    <?= $this->render("_blocks", ["model" => $model]) ?>
<?php } else { ?>
    <h2>Конкурс завершен</h2>
    <p style="text-align: center;padding: 20px;"><img src="/img/final.png"/></p>
    <div class="members-list final">
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
                            <?= $winner->user->country ? '<span class="country"><img src="/img/map.png"></span> ' . $winner->user->country->name . ' <span class="delimiter"> | </span>' : '' ?>
                            <a href="<?= $winner->user->getProfileUrl() ?>"
                               target="_blank"><?= \yii\helpers\StringHelper::truncate($winner->user->url, 30) ?></a>
                        </div>
                    <?php } ?>
                </div>

                <div class="clearfix"></div>
            </div>
        <?php } ?>
    </div>
    <h3>Благодарим всех за участие!</h3>
    <p style="text-align: center;">Организатор конкурса свяжется с победителем для вручения приза</p>
<?php } ?>
<?php
if ($model->isMy() && $model->open) {
    echo '<p style="text-align: center;padding: 20px;"><a href="/competition/edit?id='.$model->id.'" class="btn btn-lg btn-primary">Редактировать</a></p>';
}
?>
<?php
$video = $model->videoUrl();
if ($video) { ?>
    <h2>Видео конкурса</h2>

    <div style="text-align: center">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video ?>" frameborder="0"
                allowfullscreen></iframe>
    </div>
<?php } ?>
<?php if ($model->open) { ?>
    <?php
    $time = strtotime($model->date);
    if (\common\helpers\Date::now() < $model->date) { ?>
        <h1 style="text-align: center;"><?= StringHelper::dec($model->getRightDays(true), ["Осталось", "Остался", "Осталось"]) ?>
            <strong><?= $model->getRightDays() ?></strong> до окончания конкурса</h1>

        <div style="text-align: center">
            <p>Дата розыгрыша:
                <strong><?= date("d", $time) . " " . \common\helpers\Date::ruMonth(date("m", $time), 1) . " " . date("Y", $time) ?>
                    , в <?= date("H:i", $time) ?></strong></p>
        </div>
        <div class="row" style="text-align: center;padding: 20px 0;">
            <?php

            if (!$model->isMy()) { ?>
                <?php
                if (Yii::$app->session->hasFlash("competition")) {
                    echo '<p style="color: #74bd00; font-size: 24px; text-align: center;">'.Yii::$app->session->getFlash("competition").'</p>';
                } else {
                    Modal::begin([
                        'header' => '<h2>Регистрация участника</h2>',
                        "id" => "member",
                        'toggleButton' => [
                            'tag' => 'button',
                            'class' => 'btn btn-lg btn-success',
                            'label' => 'Участвовать в один клик',
                        ],
                        "clientOptions" => ["show" => $formModel->hasErrors()],
                    ]);
                    ?>
                    <?php $form = ActiveForm::begin(['id' => 'form-member', 'options' => [/*'enctype' => 'multipart/form-data'*/]]); ?>
                    <?= $form->field($formModel, 'name')->textInput(["placeholder" => "Ваше имя"])->label("Ваше имя") ?>
                    <?= $form->field($formModel, 'url')->textInput(["placeholder" => "Ссылка на Ваш профиль"])->label("Ссылка на профиль в соц. сети") ?>
                    <?= $form->field($formModel, 'country_id')->dropDownList(\common\helpers\ArrayHelper::map(\common\models\Country::find()->orderBy("pos")->all(), "id", "name"), ["prompt" => "Выберите страну"])->label("Выберите Ваше место проживания") ?>
                    <div class="form-group" style="text-align: center;">
                        <?= Html::submitButton('Принять участие', ['class' => 'btn btn-success btn-lg', 'name' => 'member-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <h2>или</h2>
                    <p>Выберите удобную социальную сеть для регистрации и участии в конкурсе</p>
                    <p><a href="/competition/member?id=<?= $model->id ?>&s=vkontakte"><img src="/img/vk.png"/></a> <a href="/competition/member?id=<?= $model->id ?>&s=facebook"><img src="/img/fb.png"/></a> <a
                            href="/competition/member?id=<?= $model->id ?>&s=twitter"><img
                                src="/img/tw.png"/></a></p>
                    <?php
                    Modal::end();
                }
                ?>
                <p style="padding-top: 25px;">Если Вы стали победителем в розыгрыше, но не выполнили условий конкурса, то
                    победитель будет переизбран
                    организатором</p>
            <?php } ?>


        </div>

    <?php }
    ?>

    <?php if ($model->isMy()) { ?>

        <div style="text-align: center; padding: 10px 0 0;">
            <a href="/competition/winner?id=<?= $model->id ?>" class="btn btn-lg btn-success">Выбрать победителя и завершить конкурс</a>
        <!--    <a href="/competition/close?id=<?/*= $model->id */?>" class="btn btn-lg btn-success">2. Завершить конкурс</a>-->


        </div>

        <a name="members">&nbsp;</a>
        <h2>Участники конкурса</h2>
        <div class="members-list">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => "_member",
                "summary" => "",
                "emptyText" => "Пока еще никто не принял участие в конкурсе",
            ]); ?>
        </div>
    <?php } ?>
<?php } ?>

