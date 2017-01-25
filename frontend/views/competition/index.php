<h1>Мои конкурсы</h1>
<?php
/** @var \common\models\Competition $model */
/* @var $this yii\web\View */

use common\helpers\StringHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = "Мои конкурсы";
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition/list"];
$this->params['breadcrumbs'][] = $this->title;
?>

<table class="table competition-table">
    <thead>
    <tr>
        <th></th>
        <th>Дата розыгрыша</th>
        <th>Участников</th>
        <th>Активность</th>
        <th>Удалить</th>
    </tr>
    </thead>
<tbody>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => "_my",
    "summary" => "",
    "emptyText" => "У Вас еще нет конкурсов",
]); ?>
</tbody>
</table>