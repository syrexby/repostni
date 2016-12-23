<?php

namespace console\components;

class Migration extends \yii\db\Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    /**
     * @param array $operations
     */
    public function createOperations($operations = [])
    {
        if (!$operations) {
            $operations = $this->getOperations();
        }

        foreach ($operations as $operation => $roles) {
            $this->createOperation($operation);
        }
    }

    /**
     * @param array $operations
     */
    public function deleteOperations($operations = [])
    {
        if (!$operations) {
            $operations = $this->getOperations();
        }

        foreach ($operations as $operation => $roles) {
            $object = \Yii::$app->authManager->getPermission($operation);
            if ($object) {
                \Yii::$app->authManager->removeChildren($object);
                \Yii::$app->authManager->remove($object);
            }
        }
    }

    /**
     * @param array $operations
     */
    public function addOperationsAccesses($operations = [])
    {
        if (!$operations) {
            $operations = $this->getOperations();
        }

        foreach ($operations as $operation => $roles) {
            $operObject = \Yii::$app->authManager->getPermission($operation);
            if (!$operObject) {
                $operObject = $this->createOperation($operation);
            }
            foreach ($roles as $role) {
                $object = \Yii::$app->authManager->getRole($role);
                if (!$object) {
                    $object = $this->createRole($role);
                }
                \Yii::$app->authManager->addChild($object, $operObject);
            }
        }
    }

    /**
     * @param array $operations
     */
    public function revokeOperationsAccesses($operations = [])
    {
        if (!$operations) {
            $operations = $this->getOperations();
        }

        foreach ($operations as $oper => $roles) {
            $operation = \Yii::$app->authManager->getPermission($oper);
            if (!$operation) {
                continue;
            }
            foreach ($roles as $role) {
                $object = \Yii::$app->authManager->getRole($role);
                if (!$object) {
                    continue;
                }
                \Yii::$app->authManager->removeChild($object, $operation);
            }
        }
    }

    /**
     * @param $role
     */
    public function deleteRole($role)
    {
        $object = \Yii::$app->authManager->getRole($role);
        if (!$object) {
            return;
        }
        \Yii::$app->authManager->remove($object);
    }

    /**
     * @param $role
     * @param $userId
     */
    public function assign($role, $userId)
    {
        $obj = \Yii::$app->authManager->getRole($role);
        \Yii::$app->authManager->assign($obj, $userId);
    }

    /**
     * @param $name
     * @return \yii\rbac\Permission
     */
    protected function createOperation($name)
    {
        $object = \Yii::$app->authManager->createPermission($name);
        \Yii::$app->authManager->add($object);
        return $object;
    }

    /**
     * @param $name
     * @param \yii\rbac\Rule $rule
     * @return \yii\rbac\Role
     */
    protected function createRole($name, $rule = null)
    {
        $object = \Yii::$app->authManager->createRole($name);
        if ($rule) {
            $ruleObject = \Yii::$app->authManager->getRule($rule->name);
            if (!$ruleObject) {
                \Yii::$app->authManager->add($rule);
            }
            $object->ruleName = $rule->name;
        }
        \Yii::$app->authManager->add($object);
        return $object;
    }
}