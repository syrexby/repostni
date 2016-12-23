<?php

// use yii\db\Schema;
use console\components\Migration;

class m160916_124432_fix_competition_user extends Migration
{
    public function getOperations()
    {
//        return ["Controller:Action" => ["role1", "role2"]];
        return [];
    }

    public function safeUp()
    {
        $this->truncateTable("competition_winner");
        $this->truncateTable("competition_user");
        $this->dropPrimaryKey("competition_user_pk", "competition_user");
        $this->dropColumn("competition_user", "user_id");
        $this->dropColumn("competition_user", "selected");
        $this->addColumn("competition_user", "name", $this->string()->notNull());
        $this->addColumn("competition_user", "url", $this->string()->notNull());
        $this->addColumn("competition_user", "country_id", $this->integer()->notNull());
        $this->addColumn("competition_user", "id", $this->primaryKey());

        $this->addForeignKey("competition_user_country_pk", "competition_user", "country_id", "country", "id");

        $this->dropForeignKey("competition_winner_user_fk", "competition_winner");
        $this->addForeignKey("competition_winner_user_fk", "competition_winner", "user_id", "competition_user", "id");
    }

    public function safeDown()
    {
        echo "m160916_124432_fix_competition_user cannot be reverted.\n";
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
