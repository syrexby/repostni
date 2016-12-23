<?php

// use yii\db\Schema;
use console\components\Migration;

class m160929_115736_fake_stats extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->createTable("settings", [
            "id" => $this->primaryKey(),
            "slug" => $this->string("20")->notNull()->unique(),
            "value" => $this->text()
        ]);
        $this->insert("settings", [
            "slug" => "stat",
            "value" => json_encode([
                "total" => 100,
                "min_step_down" => 1,
                "max_step_down" => 2,
                "min_step_up" => 1,
                "max_step_up" => 2
            ])
        ]);
    }

    public function safeDown()
    {
        $this->dropTable("settings");
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
