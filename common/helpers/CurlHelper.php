<?php

namespace common\helpers;

class CurlHelper
{
    public $result;
    public $code;
    public $params = array();
    public $success = false;

    private $ch = null;
    private $_fp = [];

    public function __construct()
    {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_FAILONERROR, 1);
//        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

//        curl_setopt($this->ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    public function set($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
    }


    public function http_build_query_for($arrays, $prefix = null)
    {
        $new_array = [];
        if (is_object($arrays)) {
            $arrays = get_object_vars($arrays);
        }
        foreach ($arrays AS $key => $value) {
            $k = isset($prefix) ? $prefix . '[' . $key . ']' : $key;
            if (is_array($value) || (is_object($value) && !($value instanceof \CURLFile))) {
                $new_array = array_merge($new_array, $this->http_build_query_for($value, $k));
            } else {
                $new_array[$k] = $value;
            }
        }
        return $new_array;
    }

    public function setPost($data)
    {
        $data = $this->http_build_query_for($data);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
    }

    public function setPut()
    {
        curl_setopt($this->ch, CURLOPT_PUT, true);
    }

    public function setUpload($filePath)
    {
        $fileSize = filesize($filePath);
        $this->_fp[$filePath] = @fopen($filePath, 'r');
        curl_setopt($this->ch, CURLOPT_INFILE, $this->_fp[$filePath]);
        curl_setopt($this->ch, CURLOPT_INFILESIZE, $fileSize);
        curl_setopt($this->ch, CURLOPT_UPLOAD, true);
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public function get($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);

        return $this->exec();
    }

    /**
     * @return mixed
     */
    private function exec()
    {
        $this->result = curl_exec($this->ch);
        $this->params = curl_getinfo($this->ch);
        $this->code = $this->params['http_code'];

        curl_close($this->ch);

        if ($this->code == 200) {
            $this->success = true;
        }

        foreach ($this->_fp as $fp) {
            @fclose($fp);
        }

        return $this->result;
    }
}