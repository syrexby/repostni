<?php
namespace frontend\controllers;

use common\components\App;
use common\helpers\Date;
use common\models\AdvertStatus;
use common\models\File;
use common\models\PayLog;
use common\models\Post;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\search\Post as PostSearch;
use yii\web\HttpException;

/**
 * Site controller
 */
class AdvertController extends Controller
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect("/");
    }


    public function actionCreate()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {

            $model->status_id = Post::DEFAULT_STATUS;
            $model->date = Date::now();

            if ($model->validate()) {
                $model->status_id = AdvertStatus::STATUS_WAIT;
                if ($model->save()) {
                    if ($model->photo_file_id && !is_null($model->x1) && !is_null($model->x2) && !is_null($model->y1) && !is_null($model->y2)) {
                        /** @var File $file */
                        $file = File::find()->where(["id" => $model->photo_file_id])->one();

                        $origin = File::getPath($file->path, File::$originDir, true) . "." . $file->extension;
                        $sized = File::getPath($file->path, "337_500", true) . "." . $file->extension;
                        file_get_contents($file->getUrl(337, 500, false));
                        $imgine = new \yii\imagine\Image();
                        $img = $imgine->getImagine()->open($sized);
                        $img->crop(new Point($model->x1, $model->y1), new Box((int)($model->x2 - $model->x1), (int)($model->y2 - $model->y1)));
                        $img->save($origin, ['quality' => 100]);
                        $file->clear();
                    }
//                    CurrentUser::setFlashSuccess("Вы успешно разместили объявление");
                    return $this->redirect(["/advert/pay", "id" => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSaveImage()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->photo_file_id && !is_null($model->x1) && !is_null($model->x2) && !is_null($model->y1) && !is_null($model->y2)) {
                /** @var File $file */
                $file = File::find()->where(["id" => $model->photo_file_id])->one();
                $origin = File::getPath($file->path, File::$originDir, true) . "." . $file->extension;
                $sized = File::getPath($file->path, "337_500", true) . "." . $file->extension;
                file_get_contents($file->getUrl(337, 500, false));
                $imgine = new \yii\imagine\Image();
                $img = $imgine->getImagine()->open($sized);
                $img->crop(new Point($model->x1, $model->y1), new Box((int)($model->x2 - $model->x1), (int)($model->y2 - $model->y1)));
                $img->save($origin, ['quality' => 100]);
                $file->clear();
                return Json::encode(["code" => 0, "result" => ["url" => $file->getUrl(220, 127, false) ]]);
            }
        }
        return Json::encode(["code" => 1]);
    }

    public function actionNew()
    {
        if (!isset($_POST["last"])) {
            return Json::encode(["code" => 1]);
        }

        $id = (int)$_POST["last"];

        $lastAdv = Post::find()->where(["id" => $id])->one();
        if (!$lastAdv) {
            return Json::encode(["code" => 1]);
        }

        $finder = Post::find()->andWhere(["active" => true, "status_id" => AdvertStatus::STATUS_ACTIVE])->andWhere("date > :date", ["date" => $lastAdv->date]);
        $items = [];

        foreach ($finder->orderBy("date")->limit(100)->all() as $post) {
            $items[] = [
                "id" => $post->id,
                "name" => Html::encode($post->name),
                "description" => Html::encode($post->description),
                "url" => $post->url,
                "image" => $post->photoFile ? $post->photoFile->getUrl(178, 103, true) : ""
            ];
        }
        return Json::encode(["code" => 0, "result" => ["post" => $items]]);
    }

    public function actionPay($id)
    {
        $this->layout = "blank";
        /** @var Post $model */
        $model = Post::find()->where(["id" => $id, "status_id" => AdvertStatus::STATUS_WAIT])->one();
        if (!$model) {
            return $this->redirect("/");
        }
        $model->order_id = $model->id . "_" . time();
        return $this->render("pay", ["model" => $model]);
    }

    public function actionSuccess()
    {
        $this->layout = "blank";
        CurrentUser::setFlashSuccess("Вы успешно разместили объявление");
        return $this->render("success");
    }

    public function beforeAction($action)
    {
        if ($action->id == 'status' || $action->id == 'success') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionStatus()
    {
        if (!isset($_POST["data"]) || !isset($_POST["signature"])) {
            throw new HttpException(400, "Invalid params");
        }

        $log = new PayLog();
        $log->date = Date::now();
        $log->data = base64_decode($_POST["data"]);
        $log->save();

        $sign = base64_decode($_POST["signature"]);
        if (sha1(\Yii::$app->params["pay_private_key"] . $_POST["data"] . \Yii::$app->params["pay_private_key"], 1) != $sign) {
            throw new HttpException(400, "Invalid signature");
        }

        $data = Json::decode(base64_decode($_POST["data"]));
        if (is_array($data) && isset($data["status"]) && isset($data["order_id"]) && ($data["status"] == "success" || $data["status"] == "wait_accept")) {
            $order = explode("_", $data["order_id"]);
            $adv = Post::find()->where(["id" => $order[0]])->one();
            if ($adv && $adv->status_id == AdvertStatus::STATUS_WAIT) {
                $adv->status_id = AdvertStatus::STATUS_ACTIVE;
                $adv->date = Date::now();
                $adv->save();
            }
        }
    }

    public function actionAdmin()
    {
        if (Yii::$app->user->isGuest) {
            throw new HttpException(404);
        }

        if (Yii::$app->user->identity->role != App::ROLE_ADMIN) {
            throw new HttpException(404);
        }

        return $this->render("admin");
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest) {
            throw new HttpException(404);
        }

        if (Yii::$app->user->identity->role != App::ROLE_ADMIN) {
            throw new HttpException(404);
        }
        if (!isset($_POST["id"])) {
            throw new HttpException(400);
        }
        $id = (int)$_POST["id"];
        $model = Post::find()->where(["id" => $id])->one();
        if (!$model) {
            throw new HttpException(404);
        }



        $model->active = false;
        $oldPhoto = $model->photo_file_id;
        $model->photo_file_id = null;
        $model->save(false);
        if ($oldPhoto) {
            $file = File::findOne($oldPhoto);
            $file->remove();
        }
        return Json::encode(["code" => 0]);
    }

}
