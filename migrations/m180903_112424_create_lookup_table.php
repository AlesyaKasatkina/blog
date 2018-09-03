<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lookup`.
 */
class m180903_112424_create_lookup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lookup', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->integer(),
            'type' => $this->string(),
            'position' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lookup');
    }
}
