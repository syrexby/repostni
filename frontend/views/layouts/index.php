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

<section class="box-1">
<?= $this->render("_head") ?>
</section>

<section class="box-2">
<div class="container index-free-concurs">
    <div class="row">
        <div class="col-md-6">
            <iframe width="100%" height="280px" src="https://www.youtube.com/embed/grFRFHNu0Yc" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="col-md-6">
            <p class="index-free-concurs-text">Бесплатный и удобный сервис для проведения конкурсов</p>
            <a href="/competition/create" class="btn btn-success index-free-concurs-a">Бесплатно создать конкурс</a>
        </div>
    </div>
</div>
</section>

<section class="box-3">
    <div class="container">
        <div class="row">
            <div class="top-concurs">
                <h1>Топ конкурсов</h1>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="col-md-2 colll">.</li>
                    <li role="presentation" class="active col-md-4"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Топ новых конкурсов</a></li>
                    <li role="presentation" class="col-md-4"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Сегодня заканчиваются</a></li>
                    <li class="col-md-2 colll">.</li>    
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="index-concurs col-md-3 col-xs-6">
                            <a href="#">
                                <div class="img">
                                    <div class="ostal">
                                        Осталось 2дня
                                    </div>
                                    <img src="" alt="">
                                </div>
                                <div class="text">Название данного конкурса<br/>
                                    в 2 строки здесь
                                </div>
                                <div class="count-user">
                                    <img src="/img/count-user.png" alt="">
                                    123123
                                </div>
                            </a>
                        </div>
                        <div class="index-concurs col-md-3 col-xs-6">
                            <a href="#">
                                <div class="img">
                                    <div class="ostal">
                                        Осталось 2дня
                                    </div>
                                    <img src="" alt="">
                                </div>
                                <div class="text">Название данного конкурса<br/>
                                    в 2 строки здесь
                                </div>
                                <div class="count-user">
                                    <img src="/img/count-user.png" alt="">
                                    123123
                                </div>
                            </a>
                        </div>
                        <div class="index-concurs col-md-3 col-xs-6">
                            <a href="#">
                                <div class="img">
                                    <div class="ostal">
                                        Осталось 2дня
                                    </div>
                                    <img src="" alt="">
                                </div>
                                <div class="text">Название данного конкурса<br/>
                                    в 2 строки здесь
                                </div>
                                <div class="count-user">
                                    <img src="/img/count-user.png" alt="">
                                    123123
                                </div>
                            </a>
                        </div>
                        <div class="index-concurs col-md-3 col-xs-6">
                            <a href="#">
                                <div class="img">
                                    <div class="ostal">
                                        Осталось 2дня
                                    </div>
                                    <img src="" alt="">
                                </div>
                                <div class="text">Название данного конкурса<br/>
                                    в 2 строки здесь
                                </div>
                                <div class="count-user">
                                    <img src="/img/count-user.png" alt="">
                                    123123
                                </div>
                            </a>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        22222222222222222222
                    </div>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div style="margin-top: 50px;">
                <a href="#" class="index-all-concurs">Все конкурсы</a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <?= \common\components\CurrentUser::showFlash() ?>
    </div>
</div>

<section class="box-4">
<?= $this->render("_advert", ["border" => false, "button" => true]) ?>
</section>
<section class="box-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 index-text-left">
                <h1>Немного о <span>нас</span></h1>
                <p>Хотите провести самый масштабный конкурс в социальных сетях? При помощи нашего сервиса вы организуете его в считанные минуты!<br/>
                    <b>Repostni</b> предоставляет вам уникальную возможность проведения конкурса без привязки к социальным сетям. Розыгрыш призов состоится на нашей собственной площадке!
                </p>
                <br/>
                <p>
                    Что это значит?<br/>
                    В вашем конкурсе одновременно могут принимать участие пользователи <b>Вконтакте</b>, <b>Одноклассники</b>, <b>Facebook</b>, <b>Twitter</b> и других социальных сетей. Мы предлагаем самое эффективное продвижение абсолютно бесплатно!
                </p>
            </div>
            <div class="col-md-6 index-text-right">
                <h1>Почему именно <span>мы</span></h1>
                <ul>
                    <li>Стабильная работа сервиса</li>
                    <li>Удобное поле для информации о проекте</li>
                    <li>Возможность размещения рекламы</li>
                    <li>Контроль честности результатов</li>
                    <li>Самая быстрая регистрация</li>
                </ul>
                <h1>Присоединяйтесь<br/> к нам<br/> <span style="text-decoration: underline">прямо сейчас!</span></h1>
            </div>
        </div>
        
    </div>
</section>




<?= $this->render("_footer") ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
