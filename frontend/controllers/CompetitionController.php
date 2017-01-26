<?php
namespace frontend\controllers;

use common\components\CurrentUser;
use common\helpers\Date;
use common\models\Competition;
use common\models\CompetitionCondition;
use common\models\CompetitionPrize;
use common\models\CompetitionSponsor;
use common\models\CompetitionUser;
use common\models\CompetitionWinner;
use common\models\File;
use common\models\User;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\HttpException;
use common\models\search\CompetitionUser as CompetitionUserSearch;
use common\models\search\Competition as CompetitionSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * Site controller
 *
 * @var \common\models\User $curuser
 */
class CompetitionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'save-size', 'winner', 'close', 'delete', 'edit', 'users'],
                'rules' => [

                    [
                        'actions' => ['create', 'save-size', 'winner', 'close', 'delete', 'edit', 'users'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionList()
    {
        $link = '';
        $get = Yii::$app->request->get('tab');
        if(isset($get)){
            $link = $get;
        }
        switch ($link) {
            case 'popular':
                $query = Competition::find()
                    ->select([
                        '{{competition}}.*', // получить все атрибуты конкурса
                        'COUNT({{competition_user}}.id) AS competitionUsersCount' // вычислить количество участников
                    ])
                    ->joinWith('competitionUsers') // обеспечить построение промежуточной таблицы
                    ->groupBy('{{competition}}.id') // сгруппировать результаты, чтобы заставить агрегацию работать
                    ->where(['open' => true, "active" => true])
                    ->andWhere(['>','{{competition}}.date',date('Y-m-d')]);
                $countQuery = clone $query;
                if($countQuery->count()<=150){
                    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
                }else{
                    $pages = new Pagination(['totalCount' => 150, 'pageSize' => 10]);
                }
                // приводим параметры в ссылке к ЧПУ
                $pages->pageSizeParam = false;

                $models = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['competitionuserscount'=>SORT_DESC])
                    ->all();
                break;
            case 'new':
                $query = Competition::find()
                    ->select([
                        '{{competition}}.*', // получить все атрибуты конкурса
                        'COUNT({{competition_user}}.id) AS competitionUsersCount' // вычислить количество участников
                    ])
                    ->joinWith('competitionUsers') // обеспечить построение промежуточной таблицы
                    ->groupBy('{{competition}}.id') // сгруппировать результаты, чтобы заставить агрегацию работать
                    ->where(['open' => true, "active" => true])
                    ->andWhere(['>=', "created_date", date('Y-m-d H:i:s', strtotime('-1 day'))]);
                $countQuery = clone $query;
                if($countQuery->count()<=150){
                    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
                }else{
                    $pages = new Pagination(['totalCount' => 150, 'pageSize' => 10]);
                }
                $pages->pageSizeParam = false;
                $models = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['competitionuserscount'=>SORT_DESC])
                    ->all();
                break;
            /*case 'finish':
                $query = Competition::find()->where(['>','date',date('Y-m-d')]);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
                $pages->pageSizeParam = false;

                $models = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['date'=>SORT_ASC])
                    ->all();
                break;*/
            case 'today':
                $query = Competition::find()
                    ->select([
                        '{{competition}}.*', // получить все атрибуты конкурса
                        'COUNT({{competition_user}}.id) AS competitionUsersCount' // вычислить количество участников
                    ])
                    ->joinWith('competitionUsers') // обеспечить построение промежуточной таблицы
                    ->groupBy('{{competition}}.id') // сгруппировать результаты, чтобы заставить агрегацию работать
                    ->where(['open' => true, "active" => true])
                    ->andWhere(['=','{{competition}}.date',date('Y-m-d')]);
                //$query = Competition::find()->where(['=','date',date('Y-m-d')]);
                $countQuery = clone $query;
                if($countQuery->count()<=150){
                    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
                }else{
                    $pages = new Pagination(['totalCount' => 150, 'pageSize' => 10]);
                }
                $pages->pageSizeParam = false;

                $models = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['competitionuserscount'=>SORT_DESC])
                    ->all();
                break;
            default:
                $query = Competition::find()
                    ->select([
                        '{{competition}}.*', // получить все атрибуты конкурса
                        'COUNT({{competition_user}}.id) AS competitionUsersCount' // вычислить количество участников
                    ])
                    ->joinWith('competitionUsers') // обеспечить построение промежуточной таблицы
                    ->groupBy('{{competition}}.id') // сгруппировать результаты, чтобы заставить агрегацию работать
                    ->where(['open' => true, "active" => true])
                    ->andWhere(['>','{{competition}}.date',date('Y-m-d')]);
                $countQuery = clone $query;
                if($countQuery->count()<=150){
                    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
                }else{
                    $pages = new Pagination(['totalCount' => 150, 'pageSize' => 10]);
                }
                
                // приводим параметры в ссылке к ЧПУ
                $pages->pageSizeParam = false;

                $models = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['competitionuserscount'=>SORT_DESC])
                    ->all();   
        }
        
        return $this->render('list',[
            'link' => $link,
            'models' => $models,
            'pages' => $pages,

        ]);

    }
    

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect("/");
        }
        $searchModel = new CompetitionSearch;
        $dataProvider = $searchModel->search($_GET, Yii::$app->user->id);

        return $this->render("index", [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionView($id)
    {
        $model = Competition::find()->where(["id" => $id, "active" => true])->one();
        if (!$model) {
            throw new HttpException(404);
        }

        if ($model->open) {
            $this->layout = "competition";
            
//            if($model->id == 19) {
//                $this->layout = "competition_new";
//            }
        }
//        $curuser = Yii::$app->user->identity ?: '';

        $form = new CompetitionUser();
        $form->competition_id = $model->id;
        $fromSession = false;
        if (Yii::$app->session->has("competition_user_name") && Yii::$app->session->has("competition_user_url")) {
            $fromSession = true;
            $form->name = Yii::$app->session->get("competition_user_name");
            $form->url = Yii::$app->session->get("competition_user_url");
            Yii::$app->session->remove("competition_user_name");
            Yii::$app->session->remove("competition_user_url");
        }
        $form->load(Yii::$app->request->post());
        
        if (($form->load(Yii::$app->request->post()) || $fromSession) && $form->validate()) {
            
            $form->competition_id = $model->id;
            $form->date = Date::now();
            $form->makeUrl();

            if ($form->checkUrl()) {
                $form->save(false);
                CurrentUser::setFlashSuccess("Спасибо, что стали участником конкурса. Ожидайте дату розыгрыша, желаем Вам успеха!");
//                CurrentUser::setFlash("competition", "Спасибо, что стали участником конкурса. Ожидайте дату розыгрыша, желаем Вам успеха!");
                return $this->redirect("/id" . $model->id);
            }
            $form->url = $form->getProfileUrl();
            $form->addError("url", "Этот участник уже зарегистрирован");
        }

        $searchModel = new CompetitionUserSearch;
        $dataProvider = $searchModel->search($_GET, $model->id);
        
        
//        if($model->id == 19) {
//            return $this->render("view_new", [
//                "model" => $model,
//                'dataProvider' => $dataProvider,
//                'searchModel' => $searchModel,
//                'formModel' => $form
//            ]);
//        }

        return $this->render("view", [
            "model" => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'formModel' => $form
        ]);
    }


    public function actionCreate()
    {
        $model = new Competition();
        $model->organizer = Yii::$app->user->identity->full_name;
        $model->created_date = Date::now();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->date = $model->date ? date("Y-m-d", strtotime($model->date)) : null;
            if ($model->validate() && $model->save()) {
                if ($model->photo_file_id && !is_null($model->x1) && !is_null($model->x2) && !is_null($model->y1) && !is_null($model->y2)) {
                    /** @var File $file */
                    $file = File::find()->where(["id" => $model->photo_file_id])->one();

                    $origin = File::getPath($file->path, File::$originDir, true) . "." . $file->extension;
                    $sized = File::getPath($file->path, "636_1000", true) . "." . $file->extension;
                    $imgine = new \yii\imagine\Image();
                    $img = $imgine->getImagine()->open($sized);
                    $img->crop(new Point($model->x1, $model->y1), new Box((int)($model->x2 - $model->x1), (int)($model->y2 - $model->y1)));
                    $img->save($origin, ['quality' => 100]);
                    $file->clear();
                }

                if (isset($_POST["Sponsor"])) {
                    foreach ($_POST["Sponsor"] as $sponsor) {

                        if (!trim($sponsor["name"])) {
                            continue;
                        }
                        $sModel = new CompetitionSponsor();
                        $sModel->competition_id = $model->id;
                        $sModel->name = trim($sponsor["name"]);
//                        $sModel->url = trim($sponsor["url"]);
                        $sModel->save();
                    }
                }

                if (isset($_POST["Prize"])) {
                    $i = 1;
                    foreach ($_POST["Prize"] as $sponsor) {
                        if (!trim($sponsor["name"])) {
                            continue;
                        }
                        $sModel = new CompetitionPrize();
                        $sModel->competition_id = $model->id;
                        $sModel->name = trim($sponsor["name"]);
//                        $sModel->url = trim($sponsor["url"]);
                        $sModel->position = $i;
                        $sModel->save();
                        $i++;
                    }
                }

                if (isset($_POST["Condition"])) {
                    foreach ($_POST["Condition"] as $sponsor) {
                        if (!trim($sponsor["name"])) {
                            continue;
                        }
                        $sModel = new CompetitionCondition();
                        $sModel->competition_id = $model->id;
                        $sModel->name = trim($sponsor["name"]);
                        $sModel->save();
                    }
                }
                return $this->redirect("/id" . $model->id);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = Competition::find()->where(["id" => $id, "user_id" => Yii::$app->user->id, "active" => true])->one();
        if (!$model) {
            return $this->redirect("/competition");
        }
        $oldPhoto = $model->photo_file_id;
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->date = $model->date ? date("Y-m-d", strtotime($model->date)) : null;
            if ($model->validate() && $model->save()) {
                if ($model->photo_file_id && !is_null($model->x1) && !is_null($model->x2) && !is_null($model->y1) && !is_null($model->y2)) {
                    /** @var File $file */
                    $file = File::find()->where(["id" => $model->photo_file_id])->one();

                    $origin = File::getPath($file->path, File::$originDir, true) . "." . $file->extension;
                    $sized = File::getPath($file->path, "636_1000", true) . "." . $file->extension;
                    $imgine = new \yii\imagine\Image();
                    $img = $imgine->getImagine()->open($sized);
                    $img->crop(new Point($model->x1, $model->y1), new Box((int)($model->x2 - $model->x1), (int)($model->y2 - $model->y1)));
                    $img->save($origin, ['quality' => 100]);
                    $file->clear();

                    if ($oldPhoto && $oldPhoto != $model->photo_file_id) {
                        $oldImage = File::findOne($oldPhoto);
                        $oldImage->remove();
                    }
                }

                CompetitionCondition::deleteAll(["competition_id" => $model->id]);
                CompetitionSponsor::deleteAll(["competition_id" => $model->id]);

                if (isset($_POST["Sponsor"])) {
                    foreach ($_POST["Sponsor"] as $sponsor) {

                        if (!trim($sponsor["name"])) {
                            continue;
                        }
                        $sModel = new CompetitionSponsor();
                        $sModel->competition_id = $model->id;
                        $sModel->name = trim($sponsor["name"]);
//                        $sModel->url = trim($sponsor["url"]);
                        $sModel->save();
                    }
                }

                if (isset($_POST["Prize"])) {
                    $i = 1;
                    foreach ($_POST["Prize"] as $sponsor) {
                        $sModel = CompetitionPrize::find()->where(["competition_id" => $model->id, "position" => $i])->one();

                        if (!trim($sponsor["name"])) {
                            if ($sModel) {
                                CompetitionWinner::deleteAll(["prize_id" => $sModel->id]);
                            }
                            continue;
                        }
                        if (!$sModel) {
                            $sModel = new CompetitionPrize();
                            $sModel->competition_id = $model->id;
                            $sModel->position = $i;
                        }
                        $sModel->name = trim($sponsor["name"]);
//                        $sModel->url = trim($sponsor["url"]);

                        $sModel->save();
                        $i++;
                    }
                }

                if (isset($_POST["Condition"])) {
                    foreach ($_POST["Condition"] as $sponsor) {
                        if (!trim($sponsor["name"])) {
                            continue;
                        }
                        $sModel = new CompetitionCondition();
                        $sModel->competition_id = $model->id;
                        $sModel->name = trim($sponsor["name"]);
                        $sModel->save();
                    }
                }
                return $this->redirect("/id" . $model->id);
            }
        }
//        $model
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionSaveImage()
    {
        $model = new Competition();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->photo_file_id && !is_null($model->x1) && !is_null($model->x2) && !is_null($model->y1) && !is_null($model->y2)) {
                /** @var File $file */
                $file = File::find()->where(["id" => $model->photo_file_id])->one();
                
                if ($file->user_id != Yii::$app->user->id) {
                    throw new HttpException(403);
                }
                $origin = File::getPath($file->path, File::$originDir, true) . "." . $file->extension;
                $sized = File::getPath($file->path, "636_1000", true) . "." . $file->extension;
                file_get_contents($file->getUrl(636, 1000, false));
                $imgine = new \yii\imagine\Image();
                $img = $imgine->getImagine()->open($sized);
                $img->crop(new Point($model->x1, $model->y1), new Box((int)($model->x2 - $model->x1), (int)($model->y2 - $model->y1)));
                $img->save($origin, ['quality' => 100]);
                $file->clear();
                return Json::encode(["code" => 0, "result" => ["url" => $file->getUrl(636, 1000, false) ]]);
            }
        }
        return Json::encode(["code" => 1]);
    }

    public function actionFindVideo()
    {
        $out = ["code" => "1", "result" => []];

        if (isset($_POST["url"])) {
            $url = Competition::checkVideoUrl($_POST["url"]);
            if ($url) {
                return Json::encode(["code" => 0, "result" => ["video" => $url]]);
            }
        }

        return Json::encode($out);
    }

    public function actionMember($id, $s = null)
    {
        if (!$s) {
            return $this->redirect("/id" . $id);
        }

//        if (!Yii::$app->user->isGuest) {
//            $model = CompetitionUser::find()->where(["competition_id" => $id, "user_id" => Yii::$app->user->id])->one();
//            if ($model) {
//                return $this->redirect("/competition/view?id=" . $id);
//            }
//        }

        Yii::$app->session->set("competition_member", $id);

        return $this->redirect("/site/auth?authclient=" . $s);
    }

    public function actionWinner($id)
    {
        $model = Competition::find()->where(["id" => $id, "active" => true, "open" => true])->one();
        if (!$model) {
            throw new HttpException(404);
        }

        $this->layout = "competition";

        if (!$model->isMy()) {
            return $this->redirect("/id" . $model->id);
        }

        return $this->render("winner", ["model" => $model]);
    }

    public function actionClose($id)
    {
        $model = Competition::find()->where(["id" => $id, "active" => true])->one();
        if (!$model) {
            throw new HttpException(404);
        }

        $this->layout = "competition";

        if (!$model->isMy()) {
            return $this->redirect("/id" . $model->id);
        }

        if($model->open){
            $model->open = false;
            $model->save();
            CurrentUser::setFlashSuccess("Вы завершили конкурс, спасибо, что воспользовались нашим сервисом. Надеемся скоро снова увидеть у нас Ваши новые конкурсы.");
            return $this->redirect("/id" . $model->id);
        } else{
            if (isset($_POST["Competition"])) {
                if (isset($_POST["Competition"]["video_url_final"]) && trim($_POST["Competition"]["video_url_final"])) {
                    $model->video_url_final = trim($_POST["Competition"]["video_url_final"]);
                }
                $model->save();
                CurrentUser::setFlashSuccess("Вы успешно добавили видеоотчет.");
//                $this->refresh();
                return $this->redirect("/id" . $model->id);
            }
        }
//        
        CurrentUser::setFlashWarning("Возникла непредвиденная ошибка.");
        return $this->redirect("/competition/winner?id=" . $model->id);
//        return $this->render("winner", ["model" => $model]);
    }

    public function actionSetWinner()
    {
//        $competitionId = isset($_POST["competition"]) ? (int)$_POST["competition"] : null;
        $prizeId = isset($_POST["prize"]) ? (int)$_POST["prize"] : null;

        if (/*!$competitionId || */!$prizeId) {
            throw new HttpException(400);
        }

        $prize = CompetitionPrize::find()->where(["id" => $prizeId])->one();
        if (!$prize) {
            throw new HttpException(404);
        }

        $model = Competition::find()->where(["id" => $prize->competition_id, "active" => true, "open" => true])->one();
        if (!$model || !$model->isMy()) {
            throw new HttpException(404);
        }

        $exclude = null;
        $w = CompetitionWinner::find()->where(["prize_id" => $prize->id])->one();
        if ($w) {
            $exclude = $w->user_id;
        }

        CompetitionWinner::deleteAll(["prize_id" => $prize->id]);

        $finder = CompetitionUser::find();

        $finder
            ->innerJoin("competition", "competition.id = competition_user.competition_id")
            ->innerJoin("competition_prize", "competition_prize.competition_id = competition.id")
            ->leftJoin("competition_winner", "competition_winner.user_id = competition_user.id")
            ->leftJoin("competition_prize cp2", "cp2.id = competition_winner.prize_id AND cp2.competition_id = competition.id")

            ->andWhere(["competition_prize.id" => $prize->id])
//            ->andWhere(["user.status" => User::STATUS_ACTIVE])
            ->andWhere("competition_winner.user_id is null")
            ->limit(100)
            ->orderBy(new Expression("random()"));

        if ($exclude) {
            $finder->andWhere("competition_user.id <> :exc", [":exc" => $exclude]);
        }

        $all = $finder->all();

        $count = count($all);
        if (!$count) {
            return Json::encode(["code" => 1]);
        }
        /** @var CompetitionUser $all */
        $winner = null;
        if ($count == 1) {
            $winner = $all[0];
        } else {
            $rand = rand(0, ($count - 1));
            $winner = $all[$rand];
        }

        $wModel = new CompetitionWinner(["prize_id" => $prize->id, "user_id" => $winner->id, "date" => Date::now()]);
        if(!$wModel->save()) {
            var_dump($wModel->getErrors());exit;
        }

        return Json::encode([
            "code" => 0,
            "result" => [
                "name" => $winner->name,
                "country" => $winner->country ? $winner->country->name : null,
                "url" => $winner->getProfileUrl(),
                "url_text" => StringHelper::truncate($winner->getProfileUrl(), 35),
            ]
        ]);

    }

    public function actionDelete()
    {
        if (!isset($_POST["id"])) {
            throw new HttpException(400);
        }
        $id = (int)$_POST["id"];
        $model = Competition::find()->where(["id" => $id])->one();
        if (!$model) {
            throw new HttpException(404);
        }

        if (!$model->isMy()) {
            throw new HttpException(400);
        }

        $model->active = false;
        $oldPhoto = $model->photo_file_id;
        $model->photo_file_id = null;
        $model->save();
        if ($oldPhoto) {
            $file = File::findOne($oldPhoto);
            $file->remove();
        }
        return Json::encode(["code" => 0]);
    }
    
    public function actionUsers($id = 0)
    {
        $model = Competition::find()->where(["id" => $id, "active" => true])->one();
        if (!$model || !$model->open) {
            throw new HttpException(404);
        }
        if (Yii::$app->user->isGuest || !$model->isMy()) {
            throw new HttpException(401);
        }

        $searchModel = new CompetitionUserSearch;
        $dataProvider = $searchModel->search($_GET, $model->id);
        
        return $this->render("users", ["competition" => $model, "users" => $dataProvider]);
    }
}
