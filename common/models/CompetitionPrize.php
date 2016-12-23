<?php

namespace common\models;

use Yii;
use \common\models\base\CompetitionPrize as BaseCompetitionPrize;

/**
 * This is the model class for table "competition_prize".
 */
class CompetitionPrize extends BaseCompetitionPrize
{

    public function getWinner()
    {
        return CompetitionWinner::find()->where(["prize_id" => $this->id])->one();
    }

}
