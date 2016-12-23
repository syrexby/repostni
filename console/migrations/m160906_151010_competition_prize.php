<?php

// use yii\db\Schema;
use console\components\Migration;

class m160906_151010_competition_prize extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("competition_prize", "position", $this->integer()->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn("competition_prize", "position");
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
