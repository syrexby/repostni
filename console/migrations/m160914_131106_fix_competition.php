<?php

// use yii\db\Schema;
use console\components\Migration;

class m160914_131106_fix_competition extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->dropColumn("competition", "country_id");
        $this->addColumn("competition", "country_id", $this->integer());
        $this->addForeignKey("competition_country_fk", "competition", "country_id", "country", "id");
    }

    public function safeDown()
    {
        echo "m160914_131106_fix_competition cannot be reverted.\n";
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
