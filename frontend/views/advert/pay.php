<?php
$this->title = "Загрузка...";
/** @var common\models\Post $model */
?>

<p>Пожалуйста, подождите...</p>

<div style="display: none;">
    <form method="post" action="https://www.liqpay.com/api/3/checkout" id="checkout-form">
<input type="hidden" name="data" value="<?= $model->getPayData() ?>" />
<input type="hidden" name="signature" value="<?= $model->getPaySign() ?>" />
    </form>
</div>