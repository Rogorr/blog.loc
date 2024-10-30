<?php

use yii\db\Migration;

/**
 * Class m241030_071621_seed_post_category
 */
class m241030_071621_seed_post_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%PostCategory}}', ['name'], [
            ['Категория 1'],
            ['Категория 2'],
            ['Категория 3'],
            ['Категория 4'],
            ['Категория 5'],
            ['Категория 6'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241030_071621_seed_post_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241030_071621_seed_post_category cannot be reverted.\n";

        return false;
    }
    */
}
