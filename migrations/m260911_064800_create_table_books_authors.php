<?php

use yii\db\Migration;

class m260911_064800_create_table_books_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('books_authors', [
            'book_id' => $this->integer(11)->notNull(),
            'author_id' => $this->integer(11)->notNull()
        ]);

        $this->createIndex('idx-books_authors-book_id', 'books_authors', 'book_id');
        $this->createIndex('idx-books_authors-author_id', 'books_authors', 'author_id');

        $this->addForeignKey('fk-books_authors-books', 'books_authors', 'book_id', 'books', 'id');
        $this->addForeignKey('fk-books_authors-authors', 'books_authors', 'author_id', 'authors', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('books_authors');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260911_064800_create_table_books_authors cannot be reverted.\n";

        return false;
    }
    */
}
