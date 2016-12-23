<?php

namespace common\models;

use Yii;
use \common\models\base\Setting as BaseSetting;

/**
 * This is the model class for table "settings".
 */
class Setting extends BaseSetting
{
    private static $statModel;

    public static function getStat($generate = true)
    {
        $model = self::getStatModel();
        if (!$generate) {
            return $model["total"];
        }
        $stat = Yii::$app->session->get("fake_stat", $model["total"]);
        $stat = self::generateStat($stat);
        Yii::$app->session->set("fake_stat", $stat);
        return $stat;
    }

    private static function getStatModel()
    {
        if (!self::$statModel) {
            $model = Setting::find()->where(["slug" => "stat"])->one();
            self::$statModel = json_decode($model->value, true);
        }
        return self::$statModel;
    }

    private static function generateStat($current = null)
    {
        if (!$current) {
            $current = self::getStat(false);
        }
        $acts = [1,0,1,0,1,0,1,0,1];
        shuffle($acts);
        $act = $acts[rand(1, 6)];
        if ($act == 1) {
            $val = rand(self::$statModel["min_step_up"], self::$statModel["max_step_up"]);
            return $current + $val;
        }
        $val = rand(self::$statModel["min_step_down"], self::$statModel["min_step_up"]);
        return $current - $val;
    }
}
