<?php

namespace common\models;

use common\helpers\Date;
use Imagine\Gd\Imagine;
use Yii;
use \common\models\base\File as BaseFile;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 */
class File extends BaseFile
{
    /** @var  UploadedFile */
    public $uploadFile;

    public static $allowExtension = ["jpg", "jpeg", "gif", "png"];
    public static $allowSize = ["50_50", "66_66", "100_100", "178_103", "200_200", "220_127", "235_235", "280_280", "350_350",
        "400_400", "500_500", "600_600", "636_318", "636_1000", "700_700", "800_800", "1000_1000"];

    public static $baseUrl = "image";
    public static $originDir = "origin";

    public function rules()
    {
        return array_merge(parent::rules(), [
            ["uploadFile", "file", 'extensions' => 'png, jpg'],
        ]);
    }

    public function remove()
    {
        @unlink(self::getPath($this->path, self::$originDir, true) . "." . $this->extension);
        $this->clear();
        $this->delete();
    }

    public function upload()
    {
        $image = null;
        if ($this->uploadFile) {
            $imagine = new Imagine();
            $size = $imagine->open($this->uploadFile->tempName)->getSize();
//            return $size;
            if ($size->getWidth() < 200 || $size->getHeight() < 110) {
                $this->addError("uploadFile", "Изображение слишком маленькое.");
                return false;
            }
            $path = md5($this->uploadFile->name . time() . microtime());
            $this->uploadFile->saveAs(Yii::getAlias("@cs_web") . DIRECTORY_SEPARATOR . File::getPath($path, File::$originDir) . "." . $this->uploadFile->extension);

            $this->path = $path;
            $this->extension = $this->uploadFile->extension;
            $this->date = Date::now();
//            $model->raw_url = "file://" . $this->uploadFile->name;
            $this->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            $this->save(false);
            return true;
        }

        return false;
    }

    public function getUrl($w = 200, $h = 200, $th = false)
    {
        $directory = $w . "_" . $h;
        if ($th) {
            $directory .= "_th";
        }
        return $this->makeUrl($directory);
    }

    public function getOriginUrl()
    {
        return $this->makeUrl(self::$originDir);
    }

    public function clear()
    {
        foreach (self::$allowSize as $size) {
            $sizedPath = File::getPath($this->path, $size, true) . "." . $this->extension;
            if (file_exists($sizedPath)) {
                @unlink($sizedPath);
            }
            $size .= "_th";
            $sizedPath = File::getPath($this->path, $size, true) . "." . $this->extension;
            if (file_exists($sizedPath)) {
                @unlink($sizedPath);
            }
        }
    }

    private function makeUrl($directory)
    {
        return Yii::$app->params["cs_url"] . "/" . self::$baseUrl . self::getPath($this->path, $directory) . "." . $this->extension;
    }

    /*public static function saveByUrl($url)
    {
        $content = @file_get_contents($url);
        if (!$content) {
            return null;
        }
        $ext = explode(".", $url);
        $extension = strtolower(array_pop($ext));
        if (!in_array($extension, self::$allowExtension)) {
            return null;
        }

        $path = md5($url . time() . microtime());
        file_put_contents(Yii::getAlias("@cs_web") . DIRECTORY_SEPARATOR . self::getPath($path, self::$originDir) . "." . $extension, $content);

        $model = new Image();
        $model->path = $path;
        $model->extension = $extension;
        $model->date_created = Date::now();
        $model->raw_url = $url;
        $model->save();
        return $model;
    }*/

    public static function getPath($file, $directory, $full = false)
    {
        $path = "/";
        $basePath = Yii::getAlias("@cs_web") . "/" . $directory . "/";
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777);
        }
        for ($i = 0; $i < 3; $i++) {
            $path .= $file{$i};
            if (!is_dir($basePath . $path)) {
                mkdir($basePath . $path, 0777);
            }
            $path .= "/";
        }
        $ret = $full ? Yii::getAlias("@cs_web") : "";
        return $ret . "/" . $directory . $path . $file;
    }

    public static function getNewSize($w, $h, $needW, $needH)
    {
        if ($w <= $needW && $h <= $needH) {
            return ["width" => $w, "height" => $h];
        }
        if ($w > $needW) {
            $ratio = $w / $needW;
            $w = $w / $ratio;
            $h = $h / $ratio;
        }
        if ($h > $needH) {
            $ratio = $h / $needH;
            $w = $w / $ratio;
            $h = $h / $ratio;
        }
        return ["width" => $w, "height" => $h];
    }

    /**
     * @return \Imagine\Image\BoxInterface
     */
    public function getSize()
    {
        $imgine = new \yii\imagine\Image();
        $img = $imgine->getImagine()->open(self::getPath($this->path . "." . $this->extension, self::$originDir, true));
        return $img->getSize();

    }
}
