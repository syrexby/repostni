<?php

// use yii\db\Schema;
use console\components\Migration;

class m160904_134131_user_full_name extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("user", "full_name", $this->string());
    }

    public function safeDown()
    {
        echo "m160904_134131_user_full_name cannot be reverted.\n";
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
