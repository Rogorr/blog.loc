<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m241030_071841_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('ID Пользователя, создавшего пост'),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'post_category_id' => $this->integer()->notNull()->comment('ID категории'),
            'status' => $this->integer()->defaultValue(0)->comment('Статус публикации: brandnew / published / rejected'),
            'image' => $this->string()->comment('Изображение (можно хранить строку с путем до изображения)'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата изменения'),
        ]);

        $this->createIndex('idx-post-user_id', '{{%Post}}', 'user_id');
        $this->createIndex('idx-post-category_id', '{{%Post}}', 'post_category_id');

        $this->addForeignKey(
            'fk-post-user_id', 
            '{{%Post}}', 
            'user_id', 
            '{{%user}}', 
            'id',
            'CASCADE',
            'CASCADE' 
        );

        $this->addForeignKey(
            'fk-post-category_id', 
            '{{%Post}}', 
            'post_category_id', 
            '{{%PostCategory}}', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
