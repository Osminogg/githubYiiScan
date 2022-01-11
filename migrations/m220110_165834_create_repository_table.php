<?php

use yii\db\Migration;

/**
 * Handles the creation of table `repository`.
 */
class m220110_165834_create_repository_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('repository', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('repository');
    }
}
