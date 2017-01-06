<?php
namespace frontend\controllers;

use common\components\AuthHandler;
use common\components\CurrentUser;
use common\models\User;
use common\models\Competition;
use common\models\CompetitionCondition;
use common\models\CompetitionPrize;
use common\models\CompetitionSponsor;
use common\models\CompetitionUser;
use common\models\CompetitionWinner;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'profile'],
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
   
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "index";
        return $this->render('index');
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        $model->setScenario("contacts");
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Спасибо! Сообщение успешно отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка отправки сообщения. Пожалуйста. повторите позднее.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUpdates()
    {
        return $this->render('updates');
    }

    public function actionFeedback()
    {
        $model = new ContactForm();
        $model->setScenario("feedback");
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Спасибо! Сообщение успешно отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка отправки сообщения. Пожалуйста. повторите позднее.');
            }

            return $this->refresh();
        } else {
            return $this->render('feedback', [
                'model' => $model,
            ]);
        }
    }

    public function actionDefects()
    {
        $model = new ContactForm();
        $model->setScenario("defect");
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Спасибо! Сообщение успешно отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка отправки сообщения. Пожалуйста. повторите позднее.');
            }

            return $this->refresh();
        } else {
            return $this->render('defects', [
                'model' => $model,
            ]);
        }
    }

    public function actionHelp()
    {
        return $this->render('help');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте ваш email, мы отправили туда инструкции');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Мы не смогли отправить письмо на этот адрес');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        /** @var User $model */
        $model = Yii::$app->user->identity;

        if (isset($_POST["User"]) && isset($_POST["User"]["full_name"])) {
            $model->full_name = trim($_POST["User"]["full_name"]);

            if ($model->validate(["full_name"]) && $model->save()) {
                CurrentUser::setFlashSuccess("Ваша информация успешно обновлена!");
                return $this->redirect("/profile");
            }
        }

        return $this->render("profile", ["model" => $model]);
    }

    public function onAuthSuccess($client)
    {

        (new AuthHandler($client))->handle();
    }

}
