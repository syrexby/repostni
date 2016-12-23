<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ContactForm */


?>
<div class="password-reset">
    <p>Добрый день!</p>

    <p>
        <?php
        foreach ($model->attributes as $k => $v) {
            if ($v) {
                echo "<strong>".$model->getAttributeLabel($k).":</strong> " . $v . "<br />";
            }
        }
        ?>
    </p>
</div>
