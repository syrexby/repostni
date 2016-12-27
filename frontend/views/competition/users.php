<?php
/** 
 * @var \common\models\search\CompetitionUser $dataProvider 
 * @var \common\models\Competition $competition
**/

use yii\widgets\ListView;

$this->title = "Список участников";
$this->params['breadcrumbs'][] = ["label" => "Конкурсы", "url" => "/competition"];
$this->params['breadcrumbs'][] = ["label" => $competition->name, "url" => "/id".$competition->id];
$this->params['breadcrumbs'][] = "Список участников";

?>
<h2 class="members__competition-title"><?= $competition->name ?></h2>
<h1 class="members__title"><?=$this->title. ' (' . $users->count . ')'?></h1>
<div class="members-list">
    <?= ListView::widget([
        'dataProvider' => $users,
        'itemOptions' => ['class' => 'item'],
        'itemView' => "_member",
        "summary" => "",
        "emptyText" => "Пока еще никто не принял участие в конкурсе",
    ]); ?>
</div>