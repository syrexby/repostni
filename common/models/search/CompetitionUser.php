<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CompetitionUser as CompetitionUserModel;

/**
 * CompetitionUser represents the model behind the search form about `common\models\CompetitionUser`.
 */
class CompetitionUser extends CompetitionUserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['competition_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params, $competitionId = null)
    {
        $query = CompetitionUserModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if ($competitionId) {
//            $query->andWhere(["competition_id" => $competitionId]);
            $this->competition_id = $competitionId;
        }

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([

            'competition_id' => $this->competition_id,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}