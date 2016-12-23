<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "competition_condition".
 *
 * @property integer $id
 * @property integer $competition_id
 * @property string $name
 *
 * @property \common\models\Competition $competition
 * @property string $aliasModel
 */
abstract class CompetitionCondition extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competition_condition';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['competition_id'], 'required'],
            [['competition_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['competition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competition::className(), 'targetAttribute' => ['competition_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'competition_id' => Yii::t('app', 'Competition ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetition()
    {
        return $this->hasOne(\common\models\Competition::className(), ['id' => 'competition_id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\CompetitionConditionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CompetitionConditionQuery(get_called_class());
    }


}
