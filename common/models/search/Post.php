<?php

namespace common\models\search;

use common\models\AdvertStatus;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post as PostModel;

/**
 * Post represents the model behind the search form about `common\models\Post`.
 */
class Post extends PostModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'user_id', 'photo_file_id'], 'integer'],
            [['active'], 'boolean'],
            [['name', 'description', 'url', 'date'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $this->active = true;
        $this->status_id = AdvertStatus::STATUS_ACTIVE;

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'photo_file_id' => $this->photo_file_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}