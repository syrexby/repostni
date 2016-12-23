<?php

// use yii\db\Schema;
use console\components\Migration;

class m160915_062451_winner extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("competition_user", "selected", $this->boolean()->notNull()->defaultValue(false));

        $this->createTable("competition_winner", [
            "prize_id" => $this->integer()->notNull(),
            "user_id" => $this->integer()->notNull(),
            "date" => $this->dateTime()
        ]);

        $this->addPrimaryKey("competition_winner_pk", "competition_winner", ["prize_id", "user_id"]);
        $this->addForeignKey("competition_winner_prize_fk", "competition_winner", "prize_id", "competition_prize", "id");
        $this->addForeignKey("competition_winner_user_fk", "competition_winner", "user_id", "user", "id");
    }

    public function safeDown()
    {
        echo "m160915_062451_winner cannot be reverted.\n";
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
