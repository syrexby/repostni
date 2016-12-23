<?php

namespace common\models;

class Post extends Advert
{
    const COST = 1;
    public $order_id;

    public function getPayData()
    {
        return base64_encode($this->getJsonData());
    }

    public function getPaySign()
    {
        return base64_encode(sha1(\Yii::$app->params["pay_private_key"] . $this->getPayData() . \Yii::$app->params["pay_private_key"], 1));
    }

    private function getJsonData()
    {
        return json_encode([
            "version" => 3,
            "public_key" => \Yii::$app->params["pay_public_key"],
            "action" => "pay",
            "amount" => self::COST,
            "currency" => "UAH",
            "description" => "Оплата рекламы - repostni.com",
            "order_id" => $this->order_id,
            "server_url" => "http://repostni.com/advert/status",
            "result_url" => "http://repostni.com/advert/success",
        ]);
    }
}