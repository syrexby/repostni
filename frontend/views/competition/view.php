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
$dataImage = $model->photoFile ? $model->photoFile->getUrl(636, 318) : '';
$model->description = nl2br(stripslashes($model->description));
$model->description = preg_replace('#(?<!\])\bhttp://[^\s\[<]+#i',
    "<a href=\"$0\" target=_blank>$0</a>",
    $model->description);
$model->description = preg_replace('#(?<!\])\bhttps://[^\s\[<]+#i',
    "<a href=\"$0\" target=_blank>$0</a>",
    $model->description);
//var_dump();
//phpinfo();
?>

<?php if ($model->open) { ?>
    <?= $this->render("_blocks_new", ["model" => $model]) ?>
<?php } else { ?>
    <?= $this->render("_blocks_winner", ["model" => $model]) ?>
<?php } ?>

<?php if ($model->open) { ?>
    <?php
    $time = strtotime($model->date);
    if (\common\helpers\Date::now() < $model->date) { ?>

        <div class="row uchastie" >
            <?php

            if ( !$model->isMy() && Yii::$app->user->isGuest) { ?>
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
                            'label' => Yii::$app->user->isGuest ? 'Участвовать без регистрации' : 'Участвовать',
                        ],
                        "clientOptions" => ["show" => $formModel->hasErrors()],
                    ]);
                    ?>
                    <?php $form = ActiveForm::begin(['id' => 'form-member', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($formModel, 'name')->textInput(["placeholder" => "Ваше имя"])->label("Ваше имя") ?>
                    <?= $form->field($formModel, 'url')->textInput(["placeholder" => "Ссылка на Ваш профиль"])->label("Ссылка на профиль в соц. сети") ?>
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
            <?php } else if(!$model->isMy()){  ?>
                    <p style="line-height: 40px; vertical-align: middle;">Организаторы не могу участвовать в конкурсах</p>
                <?php }?>
        </div>

    <?php }
    ?>
<?php } ?>

