<?php

namespace common\helpers;

class StringHelper
{
    /**
     * @param $count
     * @param $end [0;5-9;11-20, 1, 2-4]
     * @return string
     */
    public static function dec($count, $end)
    {
        $str = strval($count);
        $len = strlen($str);
        if (in_array($str{$len-1}, ["0", "5", "6", "7", "8", "9"]) || ($len > 1 && $str{$len-2} == "1")) {
            return $end[0];
        }
        if ($str{$len-1} == "1") {
            return $end[1];
        }
        return $end[2];
    }

    /**
     * Возвращает числа из строки
     * @param $str
     * @return int
     */
    public static function getInt($str)
    {
        return (int)preg_replace('/[^0-9]/x', '', trim($str));
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return int
     */
    public static function pos($haystack, $needle, $offset = 0)
    {
        return mb_strpos($haystack, $needle, $offset, 'utf-8');
    }

    /**
     * @param $str
     * @return int
     */
    public static function len($str)
    {
        return mb_strlen($str, 'utf-8');
    }

    /**
     * @param string $str
     * @param int $start
     * @param int|null $len
     * @return string
     */
    public static function sub($str, $start, $len = null)
    {
        if (is_null($len)) {
            $len = self::len($str);
        }
        return mb_substr($str, $start, $len, 'utf-8');
    }

    /**
     * Отменяет действие функции nl2br
     *
     * @param string $str
     * @return string
     */
    public static function unbr($str)
    {
        return strtr($str, array('<br />' => '', '<br>' => '', '<br/>' => ''));
    }

    /**
     * Смена раскладки
     *
     * @param string $str
     * @return string
     */
    public static function change_keys($str)
    {
        $arr = array('`' => 'ё', 'ё' => '`', 'q' => 'й', 'й' => 'q', 'w' => 'ц', 'ц' => 'w', 'e' => 'у', 'у' => 'e', 'r' => 'к', 'к' => 'r', 't' => 'е', 'е' => 't', 'y' => 'н', 'н' => 'y', 'u' => 'г', 'г' => 'u', 'i' => 'ш', 'ш' => 'i', 'o' => 'щ', 'щ' => 'o', 'p' => 'з', 'з' => 'p', '[' => 'х', 'х' => '[', ']' => 'ъ', 'ъ' => ']', 'a' => 'ф', 'ф' => 'a', 's' => 'ы', 'ы' => 's', 'd' => 'в', 'в' => 'd', 'f' => 'а', 'а' => 'f', 'g' => 'п', 'п' => 'g', 'h' => 'р', 'р' => 'h', 'j' => 'о', 'о' => 'j', 'k' => 'л', 'л' => 'k', 'l' => 'д', 'д' => 'l', ';' => 'ж', 'ж' => ';', "'" => 'э', 'э' => "'", 'z' => 'я', 'я' => 'z', 'x' => 'ч', 'ч' => 'x', 'c' => 'с', 'с' => 'c', 'v' => 'м', 'м' => 'v', 'b' => 'и', 'и' => 'b', 'n' => 'т', 'т' => 'n', 'm' => 'ь', 'ь' => 'm', ',' => 'б', 'б' => ',', '.' => 'ю', 'ю' => '.', '/' => '.', '~' => 'Ё', 'Ё' => '~', 'Q' => 'Й', 'Й' => 'Q', 'W' => 'Ц', 'Ц' => 'W', 'E' => 'У', 'У' => 'E', 'R' => 'К', 'К' => 'R', 'T' => 'Е', 'Е' => 'T', 'Y' => 'Н', 'Н' => 'Y', 'U' => 'Г', 'Г' => 'U', 'I' => 'Ш', 'Ш' => 'I', 'O' => 'Щ', 'Щ' => 'O', 'P' => 'З', 'З' => 'P', '{' => 'Х', 'Х' => '{', '}' => 'Ъ', 'Ъ' => '}', 'A' => 'Ф', 'Ф' => 'A', 'S' => 'Ы', 'Ы' => 'S', 'D' => 'В', 'В' => 'D', 'F' => 'А', 'А' => 'F', 'G' => 'П', 'П' => 'G', 'H' => 'Р', 'Р' => 'H', 'J' => 'О', 'О' => 'J', 'K' => 'Л', 'Л' => 'K', 'L' => 'Д', 'Д' => 'L', ':' => 'Ж', 'Ж' => ':', '"' => 'Э', 'Э' => '"', 'Z' => 'Я', 'Я' => 'Z', 'X' => 'Ч', 'Ч' => 'X', 'C' => 'С', 'С' => 'C', 'V' => 'М', 'М' => 'V', 'B' => 'И', 'И' => 'B', 'N' => 'Т', 'Т' => 'N', 'M' => 'Ь', '<' => 'Б', '>' => 'Ю', 'Ь' => 'M', 'Б' => '<', 'Ю' => '>');
        return strtr($str, $arr);
    }

    /**
     * @param $str
     * @param string $del
     * @param boolean $lower
     * @return string
     */
    public static function translite($str, $del = '-', $lower = false)
    {
        $len = mb_strlen($str, 'utf-8');
        $ret = '';
        $lastRetIsDel = true;
        $tr = array("А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya");

        for ($i = 0; $i < $len; $i++) {
            $sub = mb_substr($str, $i, 1, 'utf-8');
            $ord = ord($sub);
            if ($ord == 32 || $ord == 95 || $ord == 45) {
                $ret .= $lastRetIsDel ? "" : $del;
                $lastRetIsDel = true;
            } elseif (($ord > 47 && $ord < 58) || ($ord > 64 && $ord < 91) || ($ord > 96 && $ord < 123)) {
                $ret .= $sub;
                $lastRetIsDel = false;
            } elseif (isset($tr[$sub])) {
                $ret .= $tr[$sub];
                $lastRetIsDel = false;
            }
        }
        return $lower ? self::lower($ret) : $ret;
    }

    /**
     * @param $str
     * @return string
     */
    public static function upper($str)
    {
        return mb_strtoupper($str, 'utf-8');
    }

    /**
     * @param $str
     * @return string
     */
    public static function lower($str)
    {
        return mb_strtolower($str, 'utf-8');
    }

    /**
     * @param $str
     * @return string
     */
    public static function ucfirst($str)
    {
        $enc = 'utf-8';
        return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc);
    }

    public static function getAsInteger($string)
    {
        return (int)str_replace(' ', '', $string);
    }

    public static function getAsBoolean($string){
        if (StringHelper::lower($string) === 'false'){
            return false;
        }elseif(StringHelper::lower($string) === 'true'){
            return true;
        }else{
            return (bool)$string;
        }
    }

    public static function getAsFloat($string)
    {
        return (float)str_replace(' ', '', $string);
    }


    /**
     * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
     * @param  $number Integer Число на основе которого нужно сформировать окончание
     * @param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
     *         например array('яблоко', 'яблока', 'яблок')
     * @return String
     */

    /*
     *  % - последняя цифра в числе
     *  $rules = ["%1","%2-%4",["%5-%9","%0",'11-20']];
     *  $endings = ["заяв","ку","ки","ок"];
     */
    public static function getNumEnding($number, $endings = ["заяв","ку","ки","ок"], $rules = ["%1","%2-%4",["%5-%9","%0",'11-20']])
    {
        $lastResult = 0;
        $result = '';
        $root = array_shift($endings);
        $x = 0;
        foreach ($rules as $rule){
            $arr = !is_array($rule) ? [$rule] : $rule;
            foreach ($arr as $subRule){
                if ($lastResult < self::_applyRule($number, $subRule)){
                    $result = $root.$endings[$x];
                }
            }
            $x++;
        }
        if ($result){
            return $result;
        }else{
            return $root.$endings[0];
        }
    }

    private static function _applyRule($number, $rule)
    {
        $modPriority['comp'] = 1;
        $modPriority['%'] = 2;
        $arr = explode('-',$rule);
        $mod = '';
        foreach ($arr as &$element){
            $temp = self::_extractModifier($element);
            if (!$mod){
                $mod = $temp;
            }
        }
        $range = self::_fillRange($arr);

        switch ($mod){
            case '%':
                $end = $number%10;
                if (in_array($end,$range)){
                    return $modPriority[$mod];
                }
                break;
            case 'comp':
                if (in_array($number,$range)){
                    return $modPriority[$mod];
                }
                break;
        }
        return false;
    }

    private static function _fillRange($arr)
    {
        if (!is_array($arr)){
            return [$arr];
        }
        if (count($arr) != 2){
            return $arr;
        }
        $start = $arr[0];
        $end = $arr[1];
        $result = [];
        for ($i=(int)$start;$i<=(int)$end;$i++){
            $result[] = $i;
        }
        return $result;
    }

    private static function _extractModifier(&$str)
    {
        if (strlen($str)){
            if (!is_numeric($mod = $str[0])){
                $str = substr($str,1);
                return $mod;
            }else{
                return 'comp';
            }
        }else{
            return 'comp';
        }
    }

    /**
     * Проверяет, является ли строка Email
     *
     * @param string $str
     * @return boolean
     */
    public static function isEmail($str)
    {
        if (preg_match('%^([0-9a-z._-]+@(?:[0-9a-z_-]+\.)+[a-z]{2,4})$%Usi', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Проверяет, является ли строка Email
     *
     * @param string $str
     * @return boolean
     */
    public static function isAt($str)
    {
        if (preg_match('%^(.*@.*)$%Usi', $str)) {
            return true;
        } else {
            return false;
        }
    }

    public static function setLinks($text)
    {
        if (preg_match_all("~(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}".
            "(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|".
            "org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?".
            "!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&".
            "?+=\~/-]*)?(?:#[^ '\"&<>]*)?~i",$text,$matches)) {
            
            foreach ($matches[0] as $match) {
                $url = $match;
                if (strpos($match, "://") === false) {
                    $url = "http://" . $match;
                }
                $text = strtr($text, [$match => '<a href="'.$url.'" target="_blank">'.$match.'</a>']);
            }

        }
        return $text;

        $text = preg_replace('#(?<!\])\bhttp://[^\s\[<]+#i',
            "<a href=\"$0\" target=_blank>$0</a>",
            $text);
        $text = preg_replace('#(?<!\])\bhttps://[^\s\[<]+#i',
            "<a href=\"$0\" target=_blank>$0</a>",
            $text);
        return $text;
    }

}