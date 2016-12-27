<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "competition_user".
 *
 * @property integer $competition_id
 * @property string $date
 * @property string $name
 * @property string $url
 * @property integer $country_id
 * @property integer $id
 * @property string $url_protocol
 *
 * @property \common\models\Competition $competition
 * @property \common\models\Country $country
 * @property \common\models\CompetitionWinner[] $competitionWinners
 * @property \common\models\CompetitionPrize[] $prizes
 * @property string $aliasModel
 */
abstract class CompetitionUser extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competition_user';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['competition_id', 'name', 'url'], 'required'],
            [['competition_id', 'country_id'], 'integer'],
            [['date'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [['url_protocol'], 'string', 'max' => 10],
            [['competition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competition::className(), 'targetAttribute' => ['competition_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'competition_id' => Yii::t('app', 'Competition ID'),
            'date' => Yii::t('app', 'Date'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'country_id' => Yii::t('app', 'Country ID'),
            'id' => Yii::t('app', 'ID'),
            'url_protocol' => Yii::t('app', 'Url Protocol'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(\common\models\Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitionWinners()
    {
        return $this->hasMany(\common\models\CompetitionWinner::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizes()
    {
        return $this->hasMany(\common\models\CompetitionPrize::className(), ['id' => 'prize_id'])->viaTable('competition_winner', ['user_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\CompetitionUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CompetitionUserQuery(get_called_class());
    }


}
