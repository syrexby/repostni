<?php
/** @var common\models\Post $model */
?>

<tr id="adm-a-<?= $model->id ?>">
    <td><?= $model->photoFile ? '<img src="'.$model->photoFile->getUrl(178, 103, false).'" />' : '' ?></td>
    <td><?= $model->date ?></td>
    <td><?= $model->name ?></td>
    <td><?= $model->description ?></td>
    <td><a href="#" class="disable-post" data-id="<?= $model->id ?>"><img src="/img/close.png" /></a></td>
</tr>