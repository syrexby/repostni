<?php

// use yii\db\Schema;
use console\components\Migration;

class m160906_125951_competition extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("competition", "organizer", $this->string()->notNull());
        $this->addColumn("competition", "organizer_url", $this->string());
        $this->addColumn("competition", "created_date", $this->dateTime());

        $this->createTable("competition_sponsor", [
            "id" => $this->primaryKey(),
            "competition_id" => $this->integer()->notNull(),
            "name" => $this->string()->notNull(),
            "url" => $this->string()
        ]);
        $this->addForeignKey("competition_sponsor_competition_fk", "competition_sponsor", "competition_id", "competition", "id");

        $this->createTable("competition_condition", [
            "id" => $this->primaryKey(),
            "competition_id" => $this->integer()->notNull(),
            "name" => $this->string(),
        ]);
        $this->addForeignKey("competition_condition_competition_fk", "competition_condition", "competition_id", "competition", "id");

        $this->createTable("competition_prize", [
            "id" => $this->primaryKey(),
            "competition_id" => $this->integer()->notNull(),
            "name" => $this->string()->notNull(),
            "url" => $this->string()
        ]);
        $this->addForeignKey("competition_prize_competition_fk", "competition_prize", "competition_id", "competition", "id");
    }

    public function safeDown()
    {
        $this->dropColumn("competition", "organizer");
        $this->dropColumn("competition", "organizer_url");
        $this->dropColumn("competition", "created_date");

        $this->dropTable("competition_sponsor");

        $this->dropTable("competition_condition");

        $this->dropTable("competition_prize");
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
