<?php
/** @var CompetitionUser $model */
use common\models\CompetitionUser;

$url = $model->getProfileUrl();
?>
<span style="color: #cccccc; font-size: 20px; font-weight: bold"><?= '#'.($index + 1) ?></span> <strong style="font-size: 20px;"><?= $model->name ?></strong>
<?php if ($url) { ?>
    <a href="<?= $url ?>" class="member-link" target="_blank" style="margin-left:40px; text-decoration:underline; color:#9bda44"><i class="glyphicon glyphicon-link"></i> Ссылка</a>
<?php } ?>