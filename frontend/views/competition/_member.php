<?php
/** @var CompetitionUser $model */
use common\models\CompetitionUser;

$url = $model->getProfileUrl();
?>
<?= ($index + 1) ?>. <strong><?= $model->name ?></strong>
<br>
<div class="member-detail">
    <?php if ($model->country) { ?>
    <span class="country"><img src="/img/map.png" /></span> <?= $model->country->name ?> <span class="delimiter"> | </span>
    <?php } ?>
    <?php if ($url) { ?>
        <a href="<?= $url ?>" target="_blank"><?= $url ?></a>
    <?php } ?>
</div>