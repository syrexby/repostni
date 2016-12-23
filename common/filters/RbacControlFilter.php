<?php

namespace common\filters;

use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class RbacControlFilter extends ActionFilter
{
    /**
     * @var User|array|string the user object representing the authentication status or the ID of the user application component.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $user = "user";
    public $useAdvanced = true;

    public function init()
    {
        parent::init();
        $this->user = Instance::ensure($this->user, User::className());
    }

    public function beforeAction($action)
    {
        $operation = $this->useAdvanced ? $this->getName(\Yii::$app->id) : "";

        if ($action->controller->module && $action->controller->module->id != \Yii::$app->id) {
            $operation .= $this->getName($action->controller->module->id);
        }
        $operation .= $this->getName($action->controller->id) . ":" . $this->getName($action->id);

//        var_dump($operation);exit;

        if (\Yii::$app->user->can($operation)) {
            return parent::beforeAction($action);
        }
         $this->denyAccess($this->user);
        return false;
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
//        if ($user->getIsGuest()) {
//            $user->loginRequired();
//        } else {
            throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
//        }
    }

    private function getName($str)
    {
        $name = "";
        $arr = explode("-", $str);
        foreach ($arr as $a) {
            $name .= ucfirst($a);
        }
        return $name;
    }
}