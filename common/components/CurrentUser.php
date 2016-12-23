<?php

namespace common\components;

use yii\base\Model;
use yii\helpers\Html;

class CurrentUser
{
    public static $excludeKeys = ["competition"];

    /**
     * @param Model|string $message
     */
    public static function setFlashError($message)
    {
        if ($message instanceof Model) {
            $message = Html::errorSummary($message);
        }
        self::setFlash('error', $message);
    }

    /**
     * @param $message
     */
    public static function setFlashSuccess($message)
    {
        self::setFlash('success', $message);
    }

    /**
     * @param $message
     */
    public static function setFlashWarning($message)
    {
        self::setFlash('warning', $message);
    }

    /**
     * @param $message
     */
    public static function setFlashInfo($message)
    {
        self::setFlash('info', $message);
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public static function showFlash($key = null)
    {
        $session = \Yii::$app->getSession();
        if (!$key) {
            $out = '';
            foreach ($session->getAllFlashes(false) as $key => $value) {
                if (in_array($key, self::$excludeKeys)) {
                    continue;
                }
                $out .= self::showFlash($key);
            }
            return $out;
        } else {
            switch ($key) {
                case "success":
                    $htmlOptions = ["class" => "alert alert-success"];
                    break;
                case "error":
                    $htmlOptions = ["class" => "alert alert-danger"];
                    break;
                case "info":
                    $htmlOptions = ["class" => "alert alert-info"];
                    break;
                case "warning":
                    $htmlOptions = ["class" => "alert alert-warning"];
                    break;
                default:
                    $htmlOptions = ["class" => "alert alert-info"];
            }
            if ($session->hasFlash($key)) {
                return Html::tag('div', $session->getFlash($key), $htmlOptions);
            }
        };
    }

    /**
     * @param $name
     * @param $message
     */
    public static function setFlash($name, $message)
    {
        if (\Yii::$app->getSession()) {
            \Yii::$app->getSession()->setFlash($name, $message);
        }
    }
}