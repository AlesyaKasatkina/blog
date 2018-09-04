<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180903_112402_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'author'=> $this->string(),
            'email' => $this->string(),
            'content' => $this->string(),
            'status' => $this->integer(),
            'url' => $this->string(),
            'create_time' =>$this->date(),
            'post_id' => $this->integer(),
        ]);

        // creates index for column 'post_id'
        $this->createIndex(
            'idx-comment-post_id',
            'comment',
            'post_id'
        );

        // add foreign key for table 'post'
        $this->addForeignKey(
            'fk-comment-post_id',
            'comment',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table 'post'
        $this->dropForeignKey(
            'fk-comment-post_id',
            'comment'
        );

        // drops index for column 'post_id'
        $this->dropIndex(
            'idx-comment-post_id',
            'comment'
        );

        $this->dropTable('comment');
    }
}
