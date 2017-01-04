<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Competition as CompetitionModel;

/**
 * Competition represents the model behind the search form about `common\models\Competition`.
 */
class Competition extends CompetitionModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'photo_file_id', 'country_id'], 'integer'],
            [['name', 'description', 'video_url', 'video_url_final','date', 'organizer', 'organizer_url', 'created_date'], 'safe'],
            [['active', 'open'], 'boolean'],
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


    public function search($params, $userId = null)
    {
        $query = CompetitionModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if ($userId) {
            $this->user_id = $userId;
            $this->active = true;
        }

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'photo_file_id' => $this->photo_file_id,
            'date' => $this->date,
            'active' => $this->active,
            'created_date' => $this->created_date,
            'country_id' => $this->country_id,
            'open' => $this->open,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'video_url', $this->video_url])
            ->andFilterWhere(['like', 'video_url_final', $this->video_url_final])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->andFilterWhere(['like', 'organizer_url', $this->organizer_url]);

        return $dataProvider;
    }
}