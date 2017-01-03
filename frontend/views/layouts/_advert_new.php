<?php
if (!isset($border)) {
    $border = false;
}
if (!isset($button)) {
    $button = false;
}
?>

<div class="row addAdvert">
    <a href="/advert/create">Реклама по<br>доступной цене</a>
</div>


<?php
foreach (\common\models\Post::find()->where(["active" => true, "status_id" => \common\models\AdvertStatus::STATUS_ACTIVE])->orderBy("date DESC")->limit(20)->all() as $post) {
?>

<div class="row item" data-id="<?= $post->id ?>">
    <a href="<?= $post->url ?>" target="_blank">
        <div class="post-img"><?= $post->photoFile ? '<img src="'. $post->photoFile->getUrl(178, 103, true) .'" />' : '' ?></div>
        <h4><?= \yii\bootstrap\Html::encode($post->name) ?></h4>
        <p><?= \yii\bootstrap\Html::encode($post->description) ?></p>
    </a>
</div>

<?php } ?>