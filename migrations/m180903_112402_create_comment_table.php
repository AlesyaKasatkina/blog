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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
