<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\models\page */
/* @var $form ActiveForm */
$this->title = "Список конкурсов";
$this->params['breadcrumbs'][] = $this->title;
?>


<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
<div class="competition-list">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Топ популярных</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Топ новых</a></li>
        <!--<li role="presentation"><a href="#closed" aria-controls="closed" role="tab" data-toggle="tab">Завершившиеся</a></li>-->
        <li role="presentation"><a href="#rating" aria-controls="rating" role="tab" data-toggle="tab">Завершающиеся</a></li>
        <!--<li>

            <select name="count" id="count">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            
        </li>
 
        <script>
            $(document).ready(function() {

                $("#count").change(function(){
                    var data = ($('#count option:selected').val());
                    var msg   = $('#count').serialize();
                    $.ajax({
                        type: "POST",
                        url: "list",
                        data: msg,
                        success: function (data) {
                            console.log(data);
                        }
                    });
                })
                
            });
        </script>-->
 
        
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <div class="competiton-tbody">
                <?php
                foreach ($modelsPop as $model):?>
                    
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
                    'pagination' => $pagesPop,
                ]);?>
                </div>
            </div>
        </div>
    
        <div role="tabpanel" class="tab-pane" id="profile">
            <div class="competiton-tbody">
                <?php
                
                if($modelsToDay):
                foreach ($modelsToDay as $model):?>
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
                <?php else:?>
                    Сегодня нет созданных конкурсов!
                <?php endif;?>
                <?php echo LinkPager::widget([
                    'pagination' => $pagesToDay,
                ]);?>
            </div>
        </div>
        <!--<div role="tabpanel" class="tab-pane" id="closed">
            <div class="competiton-tbody">
                <?php
/*                if($modelsClosed):
                    foreach ($modelsClosed as $model):*/?>
                        <div class="competition-tr">
                            <div style="width: 70px;">
                                <?php
/*                                if($model->photoFile != NULL){
                                    echo '<img width="50" height="50" src="'.$model->photoFile->getUrl().'"';
                                }
                                */?>
                                <img src="/img/blank.png" height="50" width="50" alt="">
                            </div>
                            <div style="width: 250px; word-wrap: break-word;"><a href="/id<?/*= $model->id*/?>" class="link"><span><?/*= $model->name;*/?></span></a></div>
                            <div style="width: 150px; text-align: left; padding-left: 15px; padding-top: 3px;">
                                <?php
/*
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
                                */?>
                            </div>
                            <div style="width: 60px; text-align: center; padding-top: 3px;"><i class="glyphicon glyphicon-user" style="color:#545454; padding-right: 10px;"></i><?/*= $model->getMembersCount();*/?></div>
                            <div style="width: 120px; text-align: center; padding-top: 3px;"><a href="/id<?/*= $model->id*/?>" class="more">Подробнее</a></div>
                        </div>
                    <?php /*endforeach;*/?>
                <?php /*else:*/?>
                    Нет конкурсов которые завершаются сегодня!
                <?php /*endif;*/?>
                <?php /*echo LinkPager::widget([
                    'pagination' => $pagesClosed,
                ]);*/?>
            </div>
        </div>-->
        <div role="tabpanel" class="tab-pane" id="rating">
            <div class="competiton-tbody">
                <?php
                if($modelsClosed):
                    foreach ($modelsClosed as $model):?>
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
                <?php else:?>
                    Нет конкурсов которые завершаются сегодня!
                <?php endif;?>
                <?php echo LinkPager::widget([
                    'pagination' => $pagesClosed,
                ]);?>
            </div>
        </div>
    </div>
</div>


