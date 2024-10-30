<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%PostCategory}}`.
 */
class m241030_070819_create_PostCategory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%PostCategory}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique()->comment('Название категории (уникальный)'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%PostCategory}}');
    }
}
