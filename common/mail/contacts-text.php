Добрый день!<?= "\n" ?>
<?php
foreach ($model->attributes as $k => $v) {
    if ($v) {
        echo $model->getAttributeLabel($k).": " . $v . "\n";
    }
}
?>