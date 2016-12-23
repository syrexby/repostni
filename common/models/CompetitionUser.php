<?php

namespace common\models;

use Yii;
use \common\models\base\CompetitionUser as BaseCompetitionUser;

/**
 * This is the model class for table "competition_user".
 */
class CompetitionUser extends BaseCompetitionUser
{

    public function rules()
    {
        return array_merge(parent::rules(), [
            ["url", "url", 'defaultScheme' => 'http'],
        ]);
    }

    public function makeUrl()
    {
        $arr = explode("?", $this->url);
        $this->url = trim($arr[0], "/");
        $arr = explode("://", $this->url);
        $this->url_protocol = $arr[0];
        $this->url = $arr[1];
        if (strpos($this->url, "www.") === 0) {
            $www = explode("www.", $this->url);
            $this->url = $www[1];
        }
    }

    public function checkUrl()
    {
        $model = CompetitionUser::find()->where(["competition_id" => $this->competition_id, "url" => $this->url])->one();
        if ($model) {
            return false;
        }
        return true;
    }

    public function getProfileUrl()
    {
        return $this->url_protocol . "://" . $this->url;
    }

}
