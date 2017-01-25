
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\Competition */

use common\models\Competition;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заполните форму конкурса';
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition/list"];
$this->params['breadcrumbs'][] = ["label" => $model->name, "url" => "/competition/view?id=" . $model->id];
$this->params['breadcrumbs'][] = $this->title;



$videoInfo = '<div class="video-info">
<p>При розыгрыше конкурса рекомендуем снимать видео Вашего экрана, далее загрузить на YouTube и указать ниже ссылку на видео, это увеличивает доверие участников к розыгрышку.</p>
<p>Для записи Вашего экрана мы рекомендуем программу <span class="ocam-icon"></span> <a href="/soft/oCam_v313.0.exe">oCam</a></p>
</div><div class="video-info-bg"></div><div id="video-frame"></div>';

?>
<h1><?= $this->title?></h1>
<?php $form = ActiveForm::begin(['id' => 'form-create', 'options' => ['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model, 'photo_file_id')->hiddenInput()->label("") ?>


<?= $form->field($model, 'name', ['template' => '<div class="form-group">{label}{input}<p class="text-muted help-text-len" data-to="competition-name"></p></div>'])->textInput(['autofocus' => false, "placeholder" => "Название конкурса", 'maxlength' => 50])->label("") ?>


<div class="form-group field-competition-image">
    <div class="form-group"><label class="control-label">Фото конкурса</label>
        <div id="image-upload-error"></div>
        <?php
        if ($model->photoFile) {
            $size = $model->photoFile->getSize();
        }
        ?>
        <div id="image-upload" class="dropzone"
             style="text-align: center; <?= $model->photoFile ? "display:none;" : "" ?>" data-model="competition"></div>
        <div id="image-crop-layer"><p>Выбранная область будет показана на странице конкурса.</p>

            <div id="image-crop"></div>
            <div style="text-align: center;padding-top:10px;"><a href="#" class="btn btn-success" id="save-crop">Сохранить
                    изображение</a> <a href="#" id="cancel-upload-image" class="btn btn-default">Отмена</a></div>
        </div>
        <div id="image-after-crop" style="<?= $model->photoFile ? "display:block;" : "" ?>">
            <div id="delete-crop-image" class="<?= $model->photoFile ? "image-exists" : "" ?>"
                 data-width="<?= $model->photoFile ? $size->getWidth() : "" ?>"><i class="fa fa-times"
                                                                                   aria-hidden="true"></i></div>
            <img <?= $model->photoFile ? 'src="' . $model->photoFile->getUrl(636, 318, true) . '"' : "" ?>/><!--<a href="#" id="edit-image" class="btn btn-primary">Редактировать</a>-->
        </div>
    </div>
</div>

<?= $form->field($model, 'video_url', ['template' => '<div class="form-group">{label}' . $videoInfo . '{input}</div>'])->textInput(["placeholder" => "Ссылка на видео с youtube (не обязательно)"]) ?>
<?= $form->field($model, 'description')->textarea(["rows" => "6","placeholder" => "Условие конкурса"])->label("Условие конкурса") ?>
<div class="organizer-block">
    <?= $form->field($model, 'organizer')->textInput([])->label("Организатор конкурса (при желании Вы можете изменить имя или организацию на определенный конкурс)") ?>
    <?= $form->field($model, 'organizer_url', ['template' => '<div class="form-group">{input}</div>'])->textInput(["placeholder" => "Ссылка на сайт, группу или страницу соц. сети (не обязательно)"])->label("") ?>
</div>

<div id="sponsor-layer">
    <?php
    $i = 1;
    foreach ($model->competitionSponsors as $sponsor) { ?>
        <div class="sponsor row" id="sponsor-<?= $i ?>">
            <div class="col-md-11">
                <div class="form-group field-competition-sponsor">
                    <label class="control-label">Спонсор <span>(если есть)</span></label>
                    <input type="text" class="form-control" name="Sponsor[<?= $i ?>][name]"
                           value="<?= Html::encode($sponsor->name) ?>" maxlength="20" placeholder="Название организации, бренда">

                </div>
                <div class="form-group field-competition-sponsor">
                    <div class="form-group"><input type="text" class="form-control"
                                                   value="<?= Html::encode($sponsor->url) ?>"
                                                   name="Sponsor[<?= $i ?>][url]"
                                                   placeholder="Ссылка на ресурс спонсора (не обязательно)"></div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="#" class="btn-remove" data-id="<?= $i ?>"><i class="fa fa-minus"
                                                                          aria-hidden="true"></i></a>
            </div>
        </div>
        <?php
        $i++;
    } ?>
</div>
<div class="add-form-item">
    <i class="fa fa-plus" aria-hidden="true"></i> <a href="#" id="add-sponsor">Добавить спонсора</a>
</div>

<div class="form-group field-competition-prize-layer">
    <label class="control-label">Победители</label>
</div>
<div id="prize-layer">
    <?php
    $i = 1;
    foreach ($model->competitionPrizes as $prize) { ?>
        <div class="prize">
            <div class="form-group field-competition-prize">
                <label class="control-label"><?= $i ?> место</label>
                <input type="text" class="form-control" maxlength="20" name="Prize[<?= $i ?>][name]"
                       value="<?= Html::encode($prize->name) ?>" placeholder="Название приза">
            </div>
            <div class="form-group field-competition-prize">
                <div class="form-group"><input type="text" class="form-control" name="Prize[<?= $i ?>][url]"
                                               value="<?= Html::encode($prize->url) ?>"
                                               placeholder="Ссылка на приз (не обязательно)"></div>
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
</div>
<div class="add-form-item">
    <i class="fa fa-plus" aria-hidden="true"></i> <a href="#" id="add-prize">Добавить победителя</a>
</div>


<!--<div id="condition-layer">
    <div class="form-group field-competition-condition">
        <label class="control-label">Условия участия</label>
    </div>
    <?php
/*    $i = 1;
    foreach ($model->competitionConditions as $condition) { */?>
        <div class="condition row" id="condition-<?/*= $i */?>"><div class="col-md-11">
            <div class="form-group field-competition-condition">

                <input type="text" class="form-control" name="Condition[<?/*= $i */?>][name]"
                       value="<?/*= Html::encode($condition->name) */?>" maxlength="50" placeholder="Условие">
            </div>
            </div>
            <div class="col-md-1">
                <a href="#" class="btn-remove" data-id="<?/*= $i */?>"><i class="fa fa-minus"
                                                                          aria-hidden="true"></i></a>
            </div>
        </div>
        <?php
/*        $i++;
    }
    */?>
</div>
<div class="add-form-item">
    <i class="fa fa-plus" aria-hidden="true"></i> <a href="#" id="add-condition">Добавить условие</a>
</div>-->
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                "language" => "ru",
                'format' => 'php: d-m-Y',
                'startDate' => date("d-m-Y"),
                'todayHighlight' => true
            ]
        ]) ?>
    </div>
    <!--<div class="col-md-6">
        <?/*= $form->field($model, 'country_id')->dropDownList(\common\helpers\ArrayHelper::map(\common\models\Country::find()->orderBy("pos")->all(), "id", "name"), ["prompt" => "Выберите страну (не обязательно)"]) */?>
    </div>-->
</div>
<div class="form-group" style="text-align: center;">
    <?= Html::submitButton('Сохранить конкурс', ['class' => 'btn btn-success btn-lg', 'name' => 'create-button']) ?>
</div>

<?php ActiveForm::end(); ?>

