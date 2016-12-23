<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PayLog]].
 *
 * @see \common\models\PayLog
 */
class PayLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\PayLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PayLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
