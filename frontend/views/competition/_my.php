<?php
/** @var Competition $model */
use common\models\Competition;
$time = strtotime($model->date);
$model->name = \yii\helpers\StringHelper::truncate($model->name, 50);
?>

<tr class="<?= $model->open ? "open" : "" ?>" data-id="<?= $model->id ?>" id="competition-<?= $model->id ?>">
    <td style="width: 200px!important; word-wrap: break-word"><?= ($index + 1) ?>. <strong><?= $model->name ?></strong></td>
    <td><?= date("d", $time) . " " . \common\helpers\Date::ruMonth(date("m", $time), 2) . " " . date("Y", $time) ?></td>
    <td><?= $model->getMembersCount() ?></td>
    <td class="status"><?= $model->open ? "Активный" : "Завершен" ?></td>
    <td><a href="#" class="disable-competition" data-id="<?= $model->id ?>"><img src="/img/close.png" /></a></td>
</tr>
