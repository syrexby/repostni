<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $phone_or_email;
    public $feedback;
    public $link;
    public $defect;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required', "on" => "contacts"],
            // email has to be a valid email address
            [["phone_or_email", "feedback", "name"], "string", "on" => "feedback"],
            [["feedback"], "required", "on" => "feedback"],
            [["link", "defect"], "required", "on" => "defect"],
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Код с картинки',
            'name' => 'Ваше имя',
            'email' => 'Ваш email',
            'subject' => 'Тема сообщения',
            'body' => 'Сообщение',
            'phone_or_email' => "Почта или мобильный номер",
            "feedback" => "Описание предложения или пожелания",
            "link" => "Ссылка на страницу с проблемой",
            "defect" => "Описание проблемы",
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {
        switch ($this->getScenario()) {
            case "defect":
                $subject = "Неполадки на сайте";
                break;
            case "feedback":
                $subject = "Пожелание или предложение";
                break;
            default:
                $subject = "Сообщение с сайта";
                break;
        }
        $this->verifyCode = null;
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'contacts-html', 'text' => 'contacts-text'],
                ['model' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($subject . ' ' . Yii::$app->name)
            ->send();
    }
}
