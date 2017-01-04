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
    <?= $this->render("_blocks_new", ["model" => $model, "formModel" => $formModel]) ?>
<?php } else { ?>
    <?= $this->render("_blocks_winner", ["model" => $model]) ?>
<?php } ?>


