<?php
use common\models\Competition;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

/** @var Competition $model */

$styleBlock1 = $model->photoFile ? 'style="background-image:url(' . $model->photoFile->getUrl(235, 235, true) . ');background-position:center;background-repeat: no-repeat"' : '';
$styleAll = !$model->photoFile ? 'style="padding-left: 117px;"' : '';
$row = explode(" ", trim($model->name));
$h2 = trim($row[0]);
$h3 = isset($row[1]) ? trim($row[1]) : "&nbsp;";
$row = explode(" ", trim($model->organizer));
$oh2 = \yii\helpers\StringHelper::truncate(trim($row[0]), 17);
$oh3 = isset($row[1]) ? \yii\helpers\StringHelper::truncate(trim($row[1]), 17) : "&nbsp;";



?>



<div class="competition-blocks" <?= $styleAll ?>>
    <?php if ($model->photoFile) : ?>
    <div class="block" id="block-1" <?= $styleBlock1 ?>>

    </div>
    <?php endif; ?>
    <div class="block" id="block-2">
        <?php if (count($model->competitionPrizes) > 1) {?>
            <div class="center">
                <?php
                Modal::begin([
                    'header' => '<h2>Все призовые места</h2>',
                    'toggleButton' => [
                        'tag' => 'a',
                        'class' => 'block-btn',
                        'label' => 'Все призовые места',
                    ],
                    'size' => 'prize-modal'
                ]);
                ?>
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


                <div class="competition-blocks" style="padding-left: <?= $p ?>px;">
                    <?php foreach ($prizes as $prize) { ?>
                        <div class="block prize-block" style="background: <?= $colors[$i] ?>">
                            <div class="block-content-header">ПРИЗ</div>
                            <div class="block-content"><p><?= $num ?> место -<br/><?= \yii\helpers\StringHelper::truncate($prize->name, 20) ?></p>
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
                <div class="clearfix"></div>

                <?php
                Modal::end();
                ?>
            </div>
        <?php } else {?>
            <div style="height: 30px;"></div>
        <?php } ?>
        <?php
        $prize = "";

        $prizeModel = $model->getMainPrize();

        if ($prizeModel) {
            $prize = '<p>1 место - <br />' . \yii\helpers\StringHelper::truncate($prizeModel->name, 20) . '</p>';
            if ($prizeModel->url) {
                $url = \common\components\App::getUrl($prizeModel->url);
                $prize .= '<a href="' . $url . '" target="_blank" class="block-link">' . \yii\helpers\StringHelper::truncate($url, 25) . '</a>';
            }

        }
        ?>

        <div class="block-content-header">ПРИЗ</div>
        <div class="block-content"><?= $prize ?></div>
    </div>
    <div class="block" id="block-3">
        <div class="block-content-header">ОРГАНИЗАТОР</div>
        <div class="block-content"><p style="color: #373e49;"><?= $oh2 . "<br />" . $oh3 ?></p>
            <?php if ($model->organizer_url) {
                echo '<a href="' . \common\components\App::getUrl($model->organizer_url) . '" target="_blank" class="block-link white">' . \yii\helpers\StringHelper::truncate($model->organizer_url, 25) . '</a>';
            } ?>
        </div>
    </div>
    <div class="block" id="block-4">
        <p>Создан: в <?= date("H:i d.m.Y", strtotime($model->created_date)) ?></p>
        <div class="block-country-name"><?= $model->country ? $model->country->name : "&nbsp;" ?></div>
        <div class="block-content-header" style="padding-top: 15px;">ДАТА РОЗЫГРЫША</div>

        <?php
        if ($model->date) {
            $time = strtotime($model->date);
            ?>
            <div class="block-content"><p
                    style="font-size: 32px; color: #373e49; font-weight: bold;"><?= date("d", $time) . " " . \common\helpers\Date::ruMonth(date("m", $time), 2) . " " . date("Y", $time) ?></p>

                <p style="color: #666;padding-top:25px;">Время <?= date("H:i", $time) ?></p>
            </div>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <?php if ($model->photoFile) : ?>
    <div class="block" id="block-5" style="padding: 20px 0 20px;">
        <?php if ($model->open && !$model->isMy()) { ?>
        <div class="center"><a href="#" style="padding:10px;" class="btn btn-lg btn-success" data-toggle="modal" data-target="#member">Участвовать в один клик</a></div>
        <?php } ?>
    </div>
    <?php endif; ?>
    <div class="block" id="block-6">
        <?php if ($model->isMy()) {?>
            <div class="center"><a href="#members" class="block-btn">Посмотреть список</a></div>
        <?php } else {?>
            <div style="height: 35px;"></div>
        <?php } ?>
        <div class="block-content-header">УЧАСТНИКОВ</div>
        <div class="block-content"><p style="font-size: 48px; color: #373e49; font-weight: bold"><?= $model->getMembersCount() ?></p></div>
    </div>
    <div class="block" id="block-7">
        <?php if (count($model->competitionConditions) > 2) {?>
            <div class="center">

                <?php
                Modal::begin([
                    'header' => '<h2>Все условия</h2>',
                    'toggleButton' => [
                        'tag' => 'a',
                        'class' => 'block-btn white',
                        'label' => 'Смотреть все условия',
                    ],
//                    'size' => Modal::SIZE_SMALL
                ]);
                ?>
                <p style="line-height: 1.5;">
                    <?php

                    foreach ($model->competitionConditions as $condition) {
                        echo '<i class="fa fa-check" aria-hidden="true"></i> ' . \common\helpers\StringHelper::setLinks($condition->name) . "<br />";

                    } ?>
                </p>

                <?php
                Modal::end();
                ?>

            </div>
        <?php } else {?>
            <div style="height: 30px;"></div>
        <?php } ?>


        <div class="block-content-header" style="color: #fff;">УСЛОВИЯ</div>
        <div class="block-content"><p style="line-height: 1.5;">
                <?php
                $i = 0;
                foreach ($model->competitionConditions as $condition) {
                    echo '<i class="fa fa-check" aria-hidden="true"></i> ' . \common\helpers\StringHelper::setLinks(\yii\helpers\StringHelper::truncate($condition->name, 50));
                    $i++;
                    if ($i == 2) {
                        break;
                    } else {
                        echo "<br />";
                    }
                } ?>
            </p></div>
    </div><?php

    if ($model->competitionSponsors) {
        $cnt = count($model->competitionSponsors);
    ?>
    <div class="block" id="block-8">
<div id="sponsor-nav" <?= $cnt < 2 ? 'style="display: none;"' : '' ?>>
    <a href="#" id="sponsor-left"><img src="/img/btn-left.png" /></a>
    <a href="#" id="sponsor-right"><img src="/img/btn-right.png" /></a>
</div>
            <div class="block-content-header" style="padding-top:<?= $cnt < 2 ? '80' : '10' ?>px;color:#8d95a2;">СПОНСОР</div>
        <div id="sponsor-owl">
            <?php foreach ($model->competitionSponsors as $sponsor) : ?>
            <div class="item"><p style="word-wrap: break-word;color:#fff;font-size: 30px;line-height:0.9;"><?= \yii\helpers\StringHelper::truncate($sponsor->name, 24) ?></p>
                <?php if ($sponsor->url) {
                    echo '<a href="' . \common\components\App::getUrl($sponsor->url) . '" target="_blank" class="block-link">' . \yii\helpers\StringHelper::truncate($sponsor->url, 25) . '</a>';
                } ?>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
    <?php
    }
    ?>
</div>

<div class="clearfix"></div>

<h2>О конкурсе</h2>

<div style="text-align: center" class="about-competition-text">
    <?= $model->description ?>
</div>