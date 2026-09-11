<?php

use yii\db\Migration;

class m260911_060339_create_table_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'isbn' => $this->string(255)->notNull(),
            'year' => $this->integer(11)->notNull(),
            'annotation' => $this->text(),
            'photo' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('books');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260911_060339_create_table_books cannot be reverted.\n";

        return false;
    }
    */
}
