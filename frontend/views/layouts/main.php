<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=1000">
    <meta property="og:image" content="<?= isset($this->params['image']) ? $this->params['image'] : '/img/logo.png' ?>">
    <meta property="og:title" content="<?= isset($this->params['title']) ? $this->params['title'] : Html::encode($this->title) ?>">
    <meta property="og:site_name" content="Repostni.com">
    <meta property="og:locale" content="ru_RU">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | repostni</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render("_head") ?>
<section class="section-bread">
<div class="container"><div class="row">
<?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>
    </div></div>
</section>    


<div class="container">
    <div class="row">
        <div class="col-md-9" style="position: relative;">
            <?= \common\components\CurrentUser::showFlash() ?>
            <?= $content ?>
        </div>

        <div class="col-md-3" style="padding-right: 0">
            <?= $this->render("_advert_right", ["border" => true, "button" => false]) ?>
        </div>
    </div>
</div>

<?= $this->render("_footer") ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
