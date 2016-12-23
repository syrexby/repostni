<?php



$this->title = "Реклама";
$this->params['breadcrumbs'][] = $this->title;
?>

<table class="table competition-table">
    <thead>
    <tr>
        <th>Картинка</th>
        <th>Дата</th>
        <th>Название</th>
        <th>Комментарий</th>
        <th>Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach (\common\models\search\Post::find()->where(["active" => true, "status_id" => \common\models\AdvertStatus::STATUS_ACTIVE])->orderBy("date DESC")->limit(50)->all() as $model) {
    echo $this->render("_item", ["model" => $model]);
    }
    ?>
    </tbody>
</table>