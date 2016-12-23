<?php

// use yii\db\Schema;
use console\components\Migration;

class m160917_115246_advert_fix extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("advert", "date", $this->dateTime());
    }

    public function safeDown()
    {
        echo "m160917_115246_advert_fix cannot be reverted.\n";
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
