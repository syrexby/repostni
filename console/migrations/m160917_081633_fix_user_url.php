<?php

// use yii\db\Schema;
use console\components\Migration;

class m160917_081633_fix_user_url extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->execute("DELETE FROM competition_user");

        $this->addColumn("competition_user", "url_protocol", $this->string(10));
    }

    public function safeDown()
    {
        $this->dropColumn("competition_user", "url_protocol");
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
