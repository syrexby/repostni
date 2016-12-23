<?php

// use yii\db\Schema;
use console\components\Migration;

class m160914_152901_user_social extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->addColumn("user", "is_social", $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn("user", "social_id", $this->string());
        $this->addColumn("user", "social_slug", $this->string());
        $this->addColumn("user", "country_id", $this->integer());

        $this->addForeignKey("user_country_id", "user", "country_id", "country", "id");

        $this->addColumn("country", "vk_id", $this->integer());
        $this->update("country", ["vk_id" => 1], ["id" => 1]);
        $this->update("country", ["vk_id" => 3], ["id" => 4]);
        $this->update("country", ["vk_id" => 4], ["id" => 3]);
        $this->update("country", ["vk_id" => 2], ["id" => 2]);

        $this->createTable("competition_user", [
            "user_id" => $this->integer()->notNull(),
            "competition_id" => $this->integer()->notNull(),
            "date" => $this->dateTime()
        ]);
        $this->addPrimaryKey("competition_user_pk", "competition_user", ["user_id", "competition_id"]);
        $this->addForeignKey("competition_user_user_fk", "competition_user", "user_id", "user", "id");
        $this->addForeignKey("competition_user_competition_fk", "competition_user", "competition_id", "competition", "id");

        $this->addColumn("competition", "open", $this->boolean()->notNull()->defaultValue(true));
    }

    public function safeDown()
    {
        echo "m160914_152901_user_social cannot be reverted.\n";
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
