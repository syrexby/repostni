<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\CompetitionSponsor]].
 *
 * @see \common\models\CompetitionSponsor
 */
class CompetitionSponsorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\CompetitionSponsor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\CompetitionSponsor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
