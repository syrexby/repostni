<?php

namespace common\helpers;

class Date
{
    public static $month = [
        "01" => ["январь", "января", "янв"],
        "02" => ["февраль", "февраля", "фев"],
        "03" => ["март", "марта", "мар"],
        "04" => ["апрель", "апреля", "апр"],
        "05" => ["май", "мая", "май"],
        "06" => ["июнь", "июня", "июн"],
        "07" => ["июль", "июля", "июл"],
        "08" => ["август", "августа", "авг"],
        "09" => ["сентябрь", "сентября", "сен"],
        "10" => ["октябрь", "октября", "окт"],
        "11" => ["ноябрь", "ноября", "ноя"],
        "12" => ["декабрь", "декабря", "дек"],
    ];
    
    /**
     * @param string $format
     * @return bool|string
     */
    public static function now($format = "Y-m-d H:i:s")
    {
        return date($format);
    }
    
    public static function ruMonth($id, $type = 0, $ucfirst = false)
    {
        if (strlen($id) < 2) {
            $id = "0" . $id;
        }
        return $ucfirst ? StringHelper::ucfirst(self::$month[$id][$type]) : self::$month[$id][$type];
    }

}