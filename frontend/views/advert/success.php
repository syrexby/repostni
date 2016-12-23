<?php
$this->title = "Загрузка...";
?>

<p>Пожалуйста, подождите...</p>

<script>
    setTimeout(function () {
        window.location.href = "/";
    }, 3000);
</script>