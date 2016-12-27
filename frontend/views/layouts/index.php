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
$stat = \common\models\Setting::getStat() . "";

$st1 = substr($stat, 0, (strlen($stat) - 1));
$st2 = substr($stat, (strlen($stat) - 1), 1);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>repostni - бесплатный и удобный сервис для организации конкурсов</title>
	<meta name="description"
              content="Бесплатный и удобный сервис для организаторов конкурсов">
	<meta property="og:image" content="//repostni.com/img/logo_big.jpg">
	<meta property="og:title" content="Repostni.com">
	<meta property="og:description" content="Бесплатный и удобный сервис для организаторов конкурсов">
	<meta property="og:url" content="https://repostni.com">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Repostni.com">
	<meta property="og:locale" content="ru_RU">
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


<div class="container about-banner">
    <div class="row">
        <div class="col-md-9 about-banner-text">
            <h1><strong><span>Бесплатный</span> и удобный сервис для организаторов</strong> по проведению любых
                конкурсов</h1>

            <div class="divider"></div>
        </div>
        <div class="col-md-3 about-banner-count">
            <strong><?= $st1 ?><span><?= $st2 ?></span></strong><br>Активных конкурсов
        </div>
    </div>
</div>
<!-- /container -->

<div class="container">
    <div class="row">
        <?= \common\components\CurrentUser::showFlash() ?>
    </div>
</div>


<?= $this->render("_advert", ["border" => false, "button" => true]) ?>



<div class="ex-block">
    <div class="container">
        <div class="row">
            <h2><span>Наши</span> преимущества</h2>
        </div>
        <div class="row">
            <div class="item">
                <div class="img"><img src="/img/ex1.png"/></div>
                <div class="descr">Конкурсы для нескольких соц. сетей одновременно</div>
            </div>
            <div class="item">
                <div class="img"><img src="/img/ex2.png"/></div>
                <div class="descr">Размещение видео с YouTube</div>
            </div>
            <div class="item">
                <div class="img"><img src="/img/ex3.png"/></div>
                <div class="descr">Возможность указания спонсоров конкурса</div>
            </div>
            <div class="item">
                <div class="img"><img src="/img/ex4.png"/></div>
                <div class="descr">Постоянный доступ к списку участников конкурса</div>
            </div>
            <div class="item">
                <div class="img"><img src="/img/ex5.png"/></div>
                <div class="descr">Размещение информации<br>об организаторе</div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row main-text">
        <h1>О нас</h1>

        <p>Хотите провести самый масштабный конкурс в социальных сетях? При помощи нашего сервиса вы организуете его в считанные минуты!</p>

        <p>repostni предоставляет вам уникальную возможность проведения конкурса без привязки к социальным сетям. Розыгрыш призов состоится на нашей собственной площадке!</p>

        <p>Что это значит?</p>

        <p>В вашем конкурсе одновременно могут принимать участие пользователи Вконтакте, Одноклассники, Facebook, Twitter и других социальных сетей. Мы предлагаем самое эффективное продвижение абсолютно бесплатно!</p>

        <p>Причины выбрать нас:</p>
        <ul>

            <li>Качественный сервис, прошедший тестирование</li>

            <li>Удобное поле для информации о проекте</li>

            <li>Возможность размещения рекламы</li>

            <li>Контроль честности результатов</li>

            <li>Самая быстрая регистрация</li>
        </ul>
        <p>Присоединяйтесь к нам прямо сейчас!</p>
    </div>
</div>

<?= $this->render("_footer") ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
