<?php
if (!isset($border)) {
    $border = false;
}
if (!isset($button)) {
    $button = false;
}
?>
<div class="container best-projects">
    <div class="row">
        <a href="/advert/create" class="create-best-project">
         
                Реклама по<br/> доступной цене
      
        </a>
    </div>
    <div id="carousel-prev" class="carousel-btn"></div>
    <div id="carousel-next" class="carousel-btn"></div>
    <div id="owl-best-projects" class="row owl-carousel owl-theme<?= $border ? " border" : "" ?>">
        <?php
        foreach (\common\models\Post::find()->where(["active" => true, "status_id" => \common\models\AdvertStatus::STATUS_ACTIVE])->orderBy("date DESC")->limit(20)->all() as $post) {
        ?>

        <div class="item" data-id="<?= $post->id ?>">
            <a href="<?= $post->url ?>" target="_blank"><div class="post-img"><?= $post->photoFile ? '<img src="'. $post->photoFile->getUrl(178, 103, true) .'" />' : '' ?></div>
                <h4><?= \yii\bootstrap\Html::encode($post->name) ?></h4>
                <p><?= \yii\bootstrap\Html::encode($post->description) ?></p></a>
        </div>

        <?php } ?>

    </div>
    <?php /*if ($button) : */?><!--
    <div class="row" style="text-align: center;">
        <a href="/competition/create" class="btn btn-success btn-lg">Создать конкурс бесплатно</a>
    </div>
    --><?php /*endif; */?>
</div>