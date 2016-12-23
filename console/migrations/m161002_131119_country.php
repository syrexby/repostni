<?php

// use yii\db\Schema;
use console\components\Migration;

class m161002_131119_country extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("country", "pos", $this->integer()->notNull()->defaultValue(0));
        $this->dropColumn("country", "slug");
    }

    public function safeDown()
    {
        echo "m161002_131119_country cannot be reverted.\n";
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
