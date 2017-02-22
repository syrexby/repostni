<?php
namespace common\components;

use common\helpers\Date;
use common\models\Competition;
use common\models\CompetitionUser;
use common\models\Country;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $competition = Yii::$app->session->get("competition_member");
        
        $attributes = $this->client->getUserAttributes();

        $social = $this->client->getId();

        $id = (string)ArrayHelper::getValue($attributes, 'id');
        $userUrl = null;
        if ($social == "vkontakte") {
            $country = ArrayHelper::getValue($attributes, 'country');
            $userUrl = isset($attributes["screen_name"]) ? $attributes["screen_name"] : "id" . $id;
            $userUrl = "https://vk.com/" . $userUrl;
            $name = trim(ArrayHelper::getValue($attributes, 'first_name') . " " . ArrayHelper::getValue($attributes, 'last_name'));
        } else {
            $country = null;
            $name = trim(ArrayHelper::getValue($attributes, 'name'));
        }
        if ($social == "twitter") {
            $userUrl = isset($attributes["screen_name"]) ? $attributes["screen_name"] : "id" . $id;
            $userUrl = "https://twitter.com/" . $userUrl;
        }
        if ($social == "facebook") {
            $userUrl = $id;
            $userUrl = "https://facebook.com/" . $userUrl;
        }
        if (!Yii::$app->user->isGuest && !$competition) {
            Yii::$app->user->logout();
        }
        $user = User::find()->andWhere(["is_social" => true, "social_slug" => $social, "social_id" => $id])->one();
        if (!$user) {
            $user = new User();
            $user->username = $user->email = $id . "_" . time() . "@" . $social . ".com";
            $user->full_name = $name;
            $user->is_social = true;
            $user->social_slug = $social;
            $user->social_id = $id;
            $user->full_name = $name;
            $user->setPassword(Yii::$app->security->generateRandomString(10));
            $user->generateAuthKey();

        }
        if ($country) {
            $cModel = Country::find()->where(["vk_id" => $country])->one();
            if ($cModel) {
                $user->country_id = $cModel->id;
            }
        }


        if (!$competition) {
            $user->save();
            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            return Yii::$app->response->redirect("/");
        }



        if ($competition) {
//            echo '<pre>';
//            var_dump($user);
//            echo '</pre>';
//            die;
            Yii::$app->session->remove("competition_member");
            if (!$user->country_id) {
                $user->country_id = 3;
//                Yii::$app->session->set("competition_user_name", $user->full_name);
//                Yii::$app->session->set("competition_user_url", $userUrl);
//                return Yii::$app->response->redirect("/id" . $competition);
            }
            $comModel = Competition::find()->where(["id" => $competition, "active" => true, "open" => true])->one();
            if ($comModel) {
                $model = new CompetitionUser();
                $model->url = $userUrl;
                $model->competition_id = $comModel->id;
                $model->country_id = $user->country->id;
                $model->date = Date::now();
                $model->name = $user->full_name;
                if ($model->validate()) {
                    $model->makeUrl();
                    if ($model->checkUrl()) {
                        $model->save(false);
                        CurrentUser::setFlashSuccess("Спасибо, что стали участником конкурса. Ожидайте дату розыгрыша, желаем Вам успеха!");
                        CurrentUser::setFlash("competition", "Спасибо, что стали участником конкурса. Ожидайте дату розыгрыша, желаем Вам успеха!");

                    } else {
                        CurrentUser::setFlashError("Этот участник уже зарегистрирован");
                    }
                } else {
                    CurrentUser::setFlashError("Произошла ошибка");
                }
            }

            return Yii::$app->response->redirect("/id" . $competition);
        }



//        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);

    }


}