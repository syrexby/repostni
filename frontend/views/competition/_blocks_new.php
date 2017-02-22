<?php

use common\models\Competition;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;


/** @var Competition $model */
$styleBlock1 = $model->photoFile ? 'style="background-image:url(' . $model->photoFile->getOriginUrl() . ');
                                    background-position:center;background-repeat: no-repeat; background-size: cover; margin-top:20px"' : '';
$styleAll = !$model->photoFile ? 'style="padding-left: 0px;"' : '';
$row = explode(" ", trim($model->name));
$h2 = trim($row[0]);
$h3 = isset($row[1]) ? trim($row[1]) : "&nbsp;";
$row = explode(" ", trim($model->organizer));
$oh2 = \yii\helpers\StringHelper::truncate(trim($row[0]), 17);
$oh3 = isset($row[1]) ? \yii\helpers\StringHelper::truncate(trim($row[1]), 17) : "&nbsp;";
?>
<h1><?= $this->title ?> <? if(!empty($oh2) or !empty($oh2)):?><? endif;?></h1>
<div class="block" id="block-0">
    <div class="concurs-date">
        <?php $time = strtotime($model->created_date);
        echo $d2 = date("d.m.Y", $time);?> -
        <?php
        $time = strtotime($model->date);
        echo $d2 = date("d.m.Y", $time);
        ?>
        
    </div>
    <div class="concurs-date-bg">
        <div class="concurs-date-romb"></div>
            <div class="concurs-date-count">
                <?php
                if ($model->date) {
                    $time = strtotime($model->date);
                    $tnow = strtotime("now");
                    ?>
                    <?php
                    $d2 = date("d.m.Y", $time);
                   
                    $datetime1 = new DateTime();
                    $datetime2 = new DateTime($d2);
                    $interval = $datetime1->diff($datetime2);
                    if($d2 == date('d.m.Y')){
                        $countDay = 0;
                        echo $countDay.' дн.';
                    }elseif($time < $tnow){
                        echo 'Завершен';
                    }else{
                        $countDay = $interval->days+1;
                        echo $countDay.' дн';
                    }
                    ?>
                <?php }?>
            </div>
    </div>
    <div class="concurs-edit">
    <?php
    if ($model->isMy() && $model->open) {
        echo '<a href="/competition/edit?id='.$model->id.'" style="background:#e5e5e5; color:black; padding:12px 20px;">Редактировать конкурс</a>';
    }?>
    </div>
    <?php
    //var_dump($model->date);
    $time = strtotime($model->date);
    $tnow = strtotime("now");
    if ($time > $tnow || date('Y-m-d') == $model->date) { ?>
    
        <?php

        if (!$model->isMy() && Yii::$app->user->isGuest) { ?>
            <div class="concurs-count">
                <?php echo '<div class="concurs-countu-romb"></div>'; ?>
                <?php echo '<div class="concurs-count-user">'.$model->getMembersCount().'</div>'; ?>
            </div>
            <div class="uchastie">
            <?php
                Modal::begin([
                    'header' => '<h2>Стать участником</h2>',
                    "id" => "member",
                    'toggleButton' => [
                        'tag' => 'button',
                        'class' => 'btn btn-lg btn-success uchastie-ok',
                        'label' => Yii::$app->user->isGuest ? 'Участвовать без регистрации' : 'Участвовать',
                    ],
                    "clientOptions" => ["show" => $formModel->hasErrors()],
                ]);
                ?>
                
                <p>Выберите удобную социальную сеть для участия в конкурсе</p>
                <p><a href="/competition/member?id=<?= $model->id ?>&s=vkontakte"><img src="/img/vk.png"/></a> <a href="/competition/member?id=<?= $model->id ?>&s=facebook"><img src="/img/fb.png"/></a> <a
                        href="/competition/member?id=<?= $model->id ?>&s=twitter"><img
                            src="/img/tw.png"/></a></p>
                <!-- <h2>или</h2>
                <?php /*$form = ActiveForm::begin(['id' => 'form-member', 'options' => ['enctype' => 'multipart/form-data']]); */?>
                <?/*= $form->field($formModel, 'name')->textInput(["placeholder" => "Ваше имя"])->label("Ваше имя") */?>
                <?/*= $form->field($formModel, 'url')->textInput(["placeholder" => "Ссылка на Ваш профиль"])->label("Ссылка на профиль в соц. сети") */?>
                <div class="form-group" style="text-align: center;">
                    <?/*= Html::submitButton('Принять участие', ['class' => 'btn btn-success btn-lg uchastie-ok', 'name' => 'member-button']) */?>
                </div>
                --><?php /*ActiveForm::end(); */?>
                
                <?php
                Modal::end();
            ?>
            </div>
        <?php } else if(!$model->isMy()){  ?>
            <div style="margin-top: 20px; text-align: right">Организаторы не могут участвовать в конкурсах</div>
        <?php }?>
    
    <?php } else{ echo '';}?>
</div>

<div class="clearfix"></div>
<?php if ($model->photoFile) : ?>
    <div class="block" id="block-1" <?= $styleBlock1 ?>>
        <?php if ($model->isMy()) {?>

            <div class="concurs-layouts" style="width:100%; overflow: hidden;  position: absolute; bottom: 0px;">
                <div class="concurs-winner" style="width: 50%;float: right; height:50px; padding-top: 20px; padding-left: 36px; background-color: white;">
                    <a href="/competition/winner?id=<?= $model->id ?>">Выбрать победителя и завершить конкурс</a>
                </div>
                <div class="block" id="block-6" style="width: 40%;float:right;overflow: hidden; background-color: white;">
                    <div class="center"><a href="/competition/users?id=<?= $model->id ?>" class="block-btn">Список участников</a></div>
                    <div class="block-content">
                        <p><?= $model->getMembersCount() ?></p>
<!--                        <div class="concurs-count-romb"></div>-->
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
<?php else:?>
    <div class="block" id="block-1" <?= $styleBlock1 ?>>
        <p>Картинка не загружена</p>
        <?php if ($model->isMy()) {?>

            <div class="concurs-layouts" style="width:100%; overflow: hidden;  position: absolute; bottom: 0px;">
                <div class="concurs-winner" style="width: 50%;float: right; height:50px; padding-top: 20px; padding-left: 36px; background-color: white;">
                    <a href="/competition/winner?id=<?= $model->id ?>">Выбрать победителя и завершить конкурс</a>
                </div>
                <div class="block" id="block-6" style="width: 40%;float:right;overflow: hidden; background-color: white;">
                    <div class="center"><a href="/competition/users?id=<?= $model->id ?>" class="block-btn">Список участников</a></div>
                    <div class="block-content">
                        <p><?= $model->getMembersCount() ?></p>
                        <!--                        <div class="concurs-count-romb"></div>-->
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
<?php endif;?>


<?php if(count($model->competitionSponsors) == 1 && count($model->competitionPrizes) == 1) { ?>
    <?php
    $prizes = \common\models\CompetitionPrize::find()->where(["competition_id" => $model->id])->orderBy("position")->all();
    $i = 0;
    $num = 1;
    $colors = ["#74bd00", "#ffc000", "#ff7800"];
    $w = 3 - count($prizes);
    if ($w < 1) {
        $w = 0;
    }
    $p = ceil(235 * $w / 2);
    ?>

    <div class="block concurs-priz-box" id="block-2" style="float: left; width: 33%; margin-top: 25px;">
        <div class="block-content-header concurs-priz-header">ПРИЗ</div>
        <div class="competition-blocks">
            <?php foreach ($prizes as $prize) { ?>
                <div class="block prize-block" style="width:200px; padding: 0px;height: auto;">
                    <div class="block-content">
                        <p>
                                <span
                                    class="concurs-priz-price"><?= \yii\helpers\StringHelper::truncate($prize->name, 20) ?></span>
                            <span class="concurs-priz-val"></span>
                            <br/>
                            <span class="concurs-priz-plac"><?= $num ?> место</span>
                        </p>
                        <?php if ($prize->url) {
                            echo '<a href="' . \common\components\App::getUrl($prize->url) . '" target="_blank" class="block-link white">' . \yii\helpers\StringHelper::truncate($prize->url, 25) . '</a>';
                        } ?>
                    </div>
                </div>
                <?php
                $i++;
                $num++;
                if ($i == 3) {
                    $i = 0;
                    $c = array_shift($colors);
                    $colors[] = $c;
                    echo '<div class="clearfix"></div>';
                }
            } ?>
        </div>
    </div>
    <?php
    $cnt = count($model->competitionSponsors);
    ?>
    <div class="block" id="block-3" style="float: left; margin-top:25px; width: 33%;">
        <div class="block-content-header concurs-org-header">ОРГАНИЗАТОР</div>

        <div class="block-content"><p class="concurs-org-name"><?= $oh2 . " " . $oh3 ?></p>
            <?php if ($model->organizer_url) {
                echo '<a href="' . \common\components\App::getUrl($model->organizer_url) . '" target="_blank" class="concurs-org-url">Перейти на сайт</a>';
            } ?>
        </div>
    </div>
    <div class="block" id="block-8" style="margin-top: 25px; float: left; width: 33%;">
        <div class="block-content-header concurs-sponsor-header">СПОНСОР</div>

        <?php foreach ($model->competitionSponsors as $sponsor) : ?>
            <div class="block-content"><p class="concurs-sponsor-name"><?= \yii\helpers\StringHelper::truncate($sponsor->name, 24) ?></p>
                <?php if ($sponsor->url) {
                    echo '<a href="' . \common\components\App::getUrl($sponsor->url) . '" target="_blank" class="concurs-sponsor-url">Перейти на сайт</a>';
                } ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php
}
else {
    if ($model->competitionPrizes > 1) { ?>
        <!------------------------------------------------->
        <?php
        $prizes = \common\models\CompetitionPrize::find()->where(["competition_id" => $model->id])->orderBy("position")->all();
        $i = 0;
        $num = 1;
        $colors = ["#74bd00", "#ffc000", "#ff7800"];
        $w = 3 - count($prizes);
        if ($w < 1) {
            $w = 0;
        }
        $p = ceil(235 * $w / 2);
        ?>

        <div class="block concurs-priz-box" id="block-2">
            <div class="block-content-header concurs-priz-header">ПРИЗЫ</div>
            <div class="competition-blocks">
                <?php foreach ($prizes as $prize) { ?>
                    <div class="block prize-block" style="width:200px; padding: 0px;height: auto;">
                        <div class="block-content">
                            <p>
                                <span
                                    class="concurs-priz-price"><?= \yii\helpers\StringHelper::truncate($prize->name, 20) ?></span>
                                <span class="concurs-priz-val"></span>
                                <br/>
                                <span class="concurs-priz-plac"><?= $num ?> место</span>
                            </p>
                            <?php if ($prize->url) {
                                echo '<a href="' . \common\components\App::getUrl($prize->url) . '" target="_blank" class="block-link white">' . \yii\helpers\StringHelper::truncate($prize->url, 25) . '</a>';
                            } ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                    $num++;
                    if ($i == 3) {
                        $i = 0;
                        $c = array_shift($colors);
                        $colors[] = $c;
                        echo '<div class="clearfix"></div>';
                    }
                } ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <!------------------------------------------------->
    <?php } ?>


    <?php
    if ($model->competitionSponsors) {
        if ($model->competitionSponsors > 1) {
            $cnt = count($model->competitionSponsors);
            ?>
            <div class="block" id="block-3">
                <div class="block-content-header concurs-org-header">ОРГАНИЗАТОР</div>

                <div class="block-content"><p class="concurs-org-name"><?= $oh2 . " " . $oh3 ?></p>
                    <?php if ($model->organizer_url) {
                        echo '<a href="' . \common\components\App::getUrl($model->organizer_url) . '" target="_blank" class="concurs-org-url">Перейти на сайт</a>';
                    } ?>
                </div>
            </div>
            <div class="block" id="block-8" style="margin-top: 25px;">
                <div class="block-content-header concurs-sponsor-header">СПОНСОРЫ</div>

                <?php foreach ($model->competitionSponsors as $sponsor) : ?>
                    <div
                        class="concurs-sponsor-name concurs-sponsor-box"><?= \yii\helpers\StringHelper::truncate($sponsor->name, 24) ?>
                        <?php if ($sponsor->url) {
                            echo '<a href="' . \common\components\App::getUrl($sponsor->url) . '" target="_blank" class="concurs-sponsor-url"><br/>Перейти на сайт</a>';
                        } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php }

    }
}
?>
<div class="clearfix"></div>
<div class="concurs-tabs tab-view">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Условия конкурса</a></li>
        <?php
        $video = $model->videoUrl();
        if ($video) { ?>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Видео конкурса</a></li>
        <?php } ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <div class="concurs-video-header">ВСЕ УСЛОВИЯ</div>
            <?= $model->description ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">
            <?php
            $video = $model->videoUrl();
            if ($video) { ?>
                <div class="concurs-video-header">ВИДЕО КОНКУРСА</div>
                <h2></h2>

                <div style="text-align: center">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video ?>" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            <?php } ?>
        </div>
    </div>

</div>
<!----------------------------------------Выпадающее меню--------------------------------------------------->
<div id="menu__popup">
    <div class="menu__conteiner">
        <div class="menu__left">
            <h1><?= $this->title ?> <? if(!empty($oh2) or !empty($oh2)):?><? endif;?></h1>
            <div class="block" id="block-0">
                <div class="concurs-date">
                    <?=$d1 = date('d.m.Y')?> -
                    <?php
                    $time = strtotime($model->date);
                    echo $d2 = date("d.m.Y", $time);
                    ?>

                </div>
                <div class="concurs-date-bg">
                    <div class="concurs-date-romb"></div>
                    <div class="concurs-date-count">
                        <?php
                        if ($model->date) {
                            $time = strtotime($model->date);
                            $tnow = strtotime("now");
                            ?>
                            <?php
                            $d2 = date("d.m.Y", $time);

                            $datetime1 = new DateTime();
                            $datetime2 = new DateTime($d2);
                            $interval = $datetime1->diff($datetime2);
                            if($d2 == date('d.m.Y')){
                                $countDay = 0;
                                echo $countDay.' дн.';
                            }elseif($time < $tnow){
                                echo 'Завершен';
                            }else{
                                $countDay = $interval->days+1;
                                echo $countDay.' дн';
                            }
                            ?>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="menu_right">
            <div class="concurs-edit">
                <?php
                if ($model->isMy() && $model->open) {
                    echo '<a href="/competition/edit?id='.$model->id.'" style="background:#e5e5e5; color:black; padding:12px 35px;">Редактировать конкурс</a>';
                }?>
            </div>
            <?php
            $time = strtotime($model->date);
            $tnow = strtotime("now");
            if ($time > $tnow || date('Y-m-d') == $model->date) { ?>

                <?php

                if (!$model->isMy() && Yii::$app->user->isGuest) { ?>
                    <div class="uchastie">
                        <?php
                            Modal::begin([
                                'header' => '<h2>Стать участником</h2>',
                                "id" => "member",
                                'toggleButton' => [
                                    'tag' => 'button',
                                    'class' => 'btn btn-lg btn-success uchastie-ok',
                                    'label' => Yii::$app->user->isGuest ? 'Участвовать без регистрации' : 'Участвовать',
                                ],
                                "clientOptions" => ["show" => $formModel->hasErrors()],
                            ]);
                            ?>

                            <p>Выберите удобную социальную сеть для участия в конкурсе</p>
                            <p><a href="/competition/member?id=<?= $model->id ?>&s=vkontakte"><img src="/img/vk.png"/></a> <a href="/competition/member?id=<?= $model->id ?>&s=facebook"><img src="/img/fb.png"/></a> <a
                                    href="/competition/member?id=<?= $model->id ?>&s=twitter"><img
                                        src="/img/tw.png"/></a></p>
                            <!--<h2>или</h2>
                            <?php /*$form = ActiveForm::begin(['id' => 'form-member', 'options' => ['enctype' => 'multipart/form-data']]); */?>
                            <?/*= $form->field($formModel, 'name')->textInput(["placeholder" => "Ваше имя"])->label("Ваше имя") */?>
                            <?/*= $form->field($formModel, 'url')->textInput(["placeholder" => "Ссылка на Ваш профиль"])->label("Ссылка на профиль в соц. сети") */?>
                            <div class="form-group" style="text-align: center;">
                                <?/*= Html::submitButton('Принять участие', ['class' => 'btn btn-success btn-lg uchastie-ok', 'name' => 'member-button']) */?>
                            </div>
                            --><?php /*ActiveForm::end(); */?>

                            <?php
                            Modal::end();
                        ?>
                    </div>
                <?php } else if(!$model->isMy()){  ?>
                    <div style="margin-top: 20px; text-align: right">Организаторы не могут участвовать в конкурсах</div>
                <?php }?>
            <?php }?>
            <?php echo '<div class="count-uch">'.$model->getMembersCount().' участников</div>'; ?>
        </div>


    </div>
</div>
