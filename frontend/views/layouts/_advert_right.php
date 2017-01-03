<?php
if (!isset($border)) {
    $border = false;
}
if (!isset($button)) {
    $button = false;
}
?>

<a href="/advert/create" class="adver-a"><div class="adver-right">Разместить рекламу по доступной цене</div></a>


    <div id="owl-best-projects" class="qweqwe" style="width: 220px; padding: 0">
    <?php
    foreach (\common\models\Post::find()->where(["active" => true, "status_id" => \common\models\AdvertStatus::STATUS_ACTIVE])->orderBy("date DESC")->limit(20)->all() as $post) {
        ?>

        <div class="item" data-id="<?= $post->id ?>" style="margin-top: 20px">
            <a href="<?= $post->url ?>" target="_blank"><div class="post-img"><?= $post->photoFile ? '<img style="width:100%;" src="'. $post->photoFile->getUrl(178, 103, true) .'" />' : '' ?></div>
                <h4 style="font-size: 15px; color:black;font-weight:bold;"><?= \yii\bootstrap\Html::encode($post->name) ?></h4>
                <p style="color:#666666;"><?= \yii\bootstrap\Html::encode($post->description) ?></p></a>
        </div>
    <?php } ?>
    </div>    


