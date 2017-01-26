<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\page */
/* @var $form ActiveForm */
$this->title = "Список конкурсов";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="competition-list">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?php if($link == '' or $link == 'popular'){ echo 'active';};?>"><a href="<?= Url::to(['competition/list']);?>?tab=popular">Топ популярных</a></li>
        <li role="presentation" class="<?php if($link == 'new'){ echo 'active';};?>"><a href="<?= Url::to(['competition/list']);?>?tab=new">Топ новых</a></li>
        <li role="presentation" class="<?php if($link == 'today'){ echo 'active';};?>"><a href="<?= Url::to(['competition/list']);?>?tab=today">Сегодня заканчиваются</a></li>
        <!--<li role="presentation" class="<?php /*if($link == 'finish'){ echo 'active';};*/?>"><a href="<?/*= Url::to(['competition/list']);*/?>?tab=finish">Завершающиеся</a></li>-->
    </ul>
    
    
    <div class="tab-content">
        <?php
        foreach ($models as $model):?>
            
            <div class="competition-tr">
                <div style="width: 70px;">
               <?php
               if($model->photoFile != NULL){
                   echo '<img width="50" height="50" src="'.$model->photoFile->getUrl().'"';
               }
               ?>
                    <img src="/img/blank.png" height="50" width="50" alt="">
                </div>
                <div style="width: 250px; word-wrap: break-word;"><a href="/id<?= $model->id?>" class="link"><span><?= $model->name;?></span></a></div>
                <div style="width: 150px; text-align: left; padding-left: 15px; padding-top: 3px;">
                    <?php
                    
                    $datetime1 = new DateTime();
                
                    $datetime2 = new DateTime($model->date);
                    $interval = $datetime1->diff($datetime2);
                    
                    $t1 = strtotime("now");
                    $t2 = strtotime($model->date);
                    if($model->date == date('Y-m-d')){
                        $countDay = 0;
                        echo $countDay.' дн. осталось';
                    }elseif ($t2 < $t1){
                        echo 'Завершен';
                    }else{
                        $countDay = $interval->days+1;
                        echo $countDay.' дн. осталось';
                    }
                    ?>
                </div>
                <div style="width: 60px; text-align: center; padding-top: 3px;"><i class="glyphicon glyphicon-user" style="color:#545454; padding-right: 10px;"></i><?= $model->getMembersCount();?></div>
                <div style="width: 120px; text-align: center; padding-top: 3px;"><a href="/id<?= $model->id?>" class="more">Подробнее</a></div>
            </div>
      
        <?php endforeach;?>
        <div style="text-align: center; margin-top: 30px;">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]);?>
        </div>
    </div>
</div>


