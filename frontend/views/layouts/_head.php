<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40354040 = new Ya.Metrika({ id:40354040, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40354040" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<div class="container">

    <!-- Static navbar -->
    <div class="navbar" role="navigation">
        <div class="row">
            <div class="col-md-5">
                <ul class="nav navbar-nav main-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
                        <ul class="dropdown-menu">
                            <li><a href="/about">Про проект</a></li>
                            <li><a href="/feedback">Ваши предложения и пожелания</a></li>
                            <li><a href="#">Наши партнеры</a></li>
                            <li><a href="/updates">Обновления в сервисе</a><!-- <span class="count">9</span>--></li>
                            <li><a href="/defects">Нашли неполадки на сайте?</a></li>
                            <li><a href="/help">Помощь проекту</a></li>
                            <li><a href="/contacts">Контакты</a></li>
                            <li class="divider"></li>
                            <li><?= Yii::$app->user->isGuest ? '<a href="/login">Вход для организаторов</a>' : '<a href="/logout">Выход</a>' ?></li>
                        </ul>
                    </li>
                    <li><a href="/help">Помощь проекту</a></li>
                </ul>
            </div>
            <div class="col-md-2 logo"><a href="/"><img src="/img/logo.png" /></a></div>
            <div class="col-md-5"><ul class="nav navbar-nav user-nav navbar-right">
                    <?php if (Yii::$app->user->isGuest) { ?>
<!--                    <li><a href="/signup">Быстрая регистрация</a></li>-->
                    <li><span class="login-icon"></span> <a href="/login">Вход для организаторов</a></li>
                    <?php }else { ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down" aria-hidden="true"></i> Здравствуйте, <?= Yii::$app->user->identity->full_name ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="/profile"><i class="fa fa-pencil" aria-hidden="true"></i> Изменить имя (организацию)</a></li>
                                <li><a href="/competition">Мои конкурсы</a></li>
                                <li><a href="/competition/create">Создать конкурс бесплатно</a></li>
                                <?php if (Yii::$app->user->identity->role == \common\components\App::ROLE_ADMIN) : ?>
                                    <li><a href="/advert/admin">Управление рекламой</a></li>
                            <?php endif; ?>
                                <li class="divider"></li>
                                <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul></div>
        </div>

    </div>
    
</div> <!-- /container -->