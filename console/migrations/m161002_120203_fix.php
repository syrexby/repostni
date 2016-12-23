<?php

// use yii\db\Schema;
use console\components\Migration;

class m161002_120203_fix extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("user", "role", $this->string());

        $model = new \common\models\User();
        $model->username = $model->email = "admin@repostni.com";
        $model->setPassword("jndfuf88");
        $model->generateAuthKey();
        $model->full_name = "Administrator";
        $model->role = \common\components\App::ROLE_ADMIN;
        $model->save();

        $this->createTable("pay_log", [
            "id" => $this->primaryKey(),
            "date" => $this->dateTime()->notNull(),
            "data" => $this->text()
        ]);
    }

    public function safeDown()
    {
        echo "m161002_120203_fix cannot be reverted.\n";
        return false;
    }

    /*
    // Use up/down to run migration code without a transaction
    public function up()
    {
    }

    public function down()
    {
    }
    */
}
