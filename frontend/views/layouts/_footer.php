<?php
use yii\helpers\Url;
?>
<div id="footer">
    <?php if(Url::to('') == '/'):?>
        <div class="container" style="border: none;">
    <?php else: ?>
        <div class="container">
    <?php endif;?>
        <div class="row">
            <div class="col-md-8 footer-copy">&copy; 2016 REPOSTNI. Бесплатный и удобный сервис для организаторов по проведению любых конкурсов</div>
            <div class="col-md-4 footer-links">
                <a href="#"><img src="/img/f-fb.png"/></a>
                <a href="#"><img src="/img/f-tw.png"/></a>
                <a href="#"><img src="/img/f-vk.png"/></a>
                <a href="#"><img src="/img/f-ok.png"/></a>
            </div>
        </div>
    </div>
</div>
