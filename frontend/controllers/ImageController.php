<?php

namespace frontend\controllers;

use common\models\File;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use yii\web\Controller;
use yii\web\HttpException;

class ImageController extends Controller
{
    public function actionIndex($_size, $_p0, $_p1, $_p2, $_path, $_ext)
    {
        $sa = explode("_", $_size);
        if (!isset($sa[1])) {
            throw new HttpException(404);
        }
        $w = $sa[0];
        $h = $sa[1];
        $th = (isset($sa[2]) && $sa[2] == "th") ? true : false;
        $size = $w . "_" . $h;
        if (!in_array($size, File::$allowSize)) {
            throw new HttpException(404);
        }
        if ($th) {
            $size .= "_th";
        }

        $image = File::find()->andWhere(["path" => $_path, "extension" => $_ext]);
        if (!$image) {
            throw new HttpException(404);
        }
        $origin = File::getPath($_path, File::$originDir, true) . "." . $_ext;
        if (!file_exists($origin)) {
            throw new HttpException(404);
        }
        $sizedPath = File::getPath($_path, $size, true) . "." . $_ext;


        if ($th) {
            \yii\imagine\Image::thumbnail($origin, $w, $h)->save($sizedPath, ['quality' => 90])->show($_ext);
        } else {
            $imgine = new \yii\imagine\Image();
            $img = $imgine->getImagine()->open($origin);
            $ss = $img->getSize();
            $newSize = File::getNewSize($ss->getWidth(), $ss->getHeight(), $w, $h);

            $box = new Box($newSize["width"], $newSize["height"]);
            $img->resize($box)->save($sizedPath, ['quality' => 90])->show($_ext);
        }
//        $this->_printImage($sizedPath, $_ext);
    }

    private function _printImage($path, $extension)
    {
        switch ($extension)
        {
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
        }

        header('Accept-Ranges: bytes');
        header('Content-Length: ' . filesize($path));
//        header("Content-type: application/image");
        echo file_get_contents($path);
        exit;
    }
}