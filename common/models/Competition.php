<?php

namespace common\models;

use common\helpers\Date;
use common\helpers\StringHelper;
use common\models\CompetitionUser;
use Yii;
use \common\models\base\Competition as BaseCompetition;

/**
 * This is the model class for table "competition".
 */
class Competition extends BaseCompetition
{
    public $x1;
    public $y1;
    public $x2;
    public $y2;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [["x1", "x2", "y1", "y2"], "safe"],
            ["date", "required"],
//            ["date",'date', 'format'=>'php: dd-mm-Y'],
            ["name", 'string', 'max' => 50]
        ]);
    }

    public function getMainPrize()
    {
        return CompetitionPrize::find()->where(["competition_id" => $this->id])->orderBy("position")->one();

    }

    public function getMainSponsor()
    {
        return CompetitionSponsor::find()->where(["competition_id" => $this->id])->orderBy("id")->one();

    }

    public function videoUrl()
    {
        return self::checkVideoUrl($this->video_url);
    }

    public function getRightDays($onlyCount = false)
    {
        $days = ceil((strtotime($this->date) - strtotime(Date::now())) / 86400);
        $asHour = false;
        if ($days < 2) {
            $days = ceil((strtotime($this->date) - strtotime(Date::now())) / 3600);
            $asHour = true;
        }
        if ($onlyCount) {
            return $days;
        }
        $arr = $asHour ? ["часов", "час", "часа"] : ["дней", "день", "дня"];
        return $days . " " .StringHelper::dec($days, $arr);
    }

    public function isMy()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if ($this->user_id == Yii::$app->user->id) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function isMember()
    {
        return false;
    }

    public function getMembersCount()
    {
        return CompetitionUser::find()->where(["competition_id" => $this->id])->count();
    }

    public static function checkVideoUrl($url)
    {
        $url = trim($url);
        $starts = ["https://youtu.be/", "https://www.youtu.be/", "https://youtube.com/embed/", "https://www.youtube.com/embed/", "https://www.youtube.com/watch?v=", "https://youtube.com/watch?v="];
        foreach ($starts as $start) {
            if (strpos($url, $start) === 0) {
                $str = explode($start, $url);
                if (isset($str[1]) && preg_match("/^([0-9a-zA-Z_-]*)/", $str[1], $matches)) {
                    return $matches[0];
                }
            }
        }
        return null;
    }

}
