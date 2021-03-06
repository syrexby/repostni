<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "settings".
 *
 * @property integer $id
 * @property string $slug
 * @property string $value
 * @property string $aliasModel
 */
abstract class Setting extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['value'], 'string'],
            [['slug'], 'string', 'max' => 20],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'value' => Yii::t('app', 'Value'),
        ];
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SettingQuery(get_called_class());
    }


}
