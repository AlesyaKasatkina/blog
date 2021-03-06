<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180903_112550_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'salt' => $this->string(),
            'email' => $this->string(),
            'profile' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
