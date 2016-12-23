<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable("file", [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "extension" => $this->string(),
            "path" => $this->string(),
            "user_id" => $this->integer(),
            "date" => $this->dateTime()
        ]);
        $this->addForeignKey("file_user_fk", "file", "user_id", "user", "id");

        $this->createTable("country", [
            "id" => $this->primaryKey(),
            "slug" => $this->string(10),
            "name" => $this->string()->notNull()
        ]);
        $this->createIndex("country_slug_idx", "country", "slug", true);
        $records = [
            ["slug" => "ru", "name" => "Россия"],
            ["slug" => "ua", "name" => "Украина"],
            ["slug" => "kz", "name" => "Казахстан"],
            ["slug" => "by", "name" => "Беларусь"],
        ];
        foreach ($records as $rec) {
            $this->insert("country", $rec);
        }

        $this->createTable("competition", [
            "id" => $this->primaryKey(),
            "user_id" => $this->integer()->notNull(),
            "name" => $this->string()->notNull(),
            "description" => $this->text(),
            "video_url" => $this->string(),
            "photo_file_id" => $this->integer(),
            "date" => $this->dateTime(),
            "country_id" => $this->integer()->notNull(),
            "active" => $this->boolean()->notNull()->defaultValue(true)

        ], $tableOptions);
        $this->addForeignKey("competition_user_fk", "competition", "user_id", "user", "id");
        $this->addForeignKey("competition_photo_fk", "competition", "photo_file_id", "file", "id");
        $this->addForeignKey("competition_country_fk", "competition", "country_id", "country", "id");

        $this->createTable("advert_status", [
            "id" => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "slug" => $this->string()->notNull()
        ]);
        $this->createIndex("advert_status_slug_idx", "advert_status", "slug", true);
        $records = [
            ["slug" => "wait", "name" => "Ожидает оплату"],
            ["slug" => "check", "name" => "Оплачено, проверка оплаты"],
            ["slug" => "active", "name" => "Оплачено, активно"],
            ["slug" => "archive", "name" => "Архив"],
        ];
        foreach ($records as $rec) {
            $this->insert("advert_status", $rec);
        }

        $this->createTable("advert", [
            "id" => $this->primaryKey(),
            "active" => $this->boolean()->notNull()->defaultValue(true),
            "status_id" => $this->integer()->notNull(),
            "user_id" => $this->integer(),
            "name" => $this->string()->notNull(),
            "description" => $this->text(),
            "photo_file_id" => $this->integer(),
            "url" => $this->string(),
        ]);
        $this->addForeignKey("advert_user_fk", "advert", "user_id", "user", "id");
        $this->addForeignKey("advert_photo_fk", "advert", "photo_file_id", "file", "id");
        $this->addForeignKey("advert_status_fk", "advert", "status_id", "advert_status", "id");
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
