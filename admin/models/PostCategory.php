<?php

namespace admin\models;

use Yii;
use yii\db\ActiveRecord;
use admin\models\PostCategory;


/**
 * This is the model class for table "PostCategory".
 *
 * @property int $id
 * @property string $name Название категории (уникальный)
 *
 * @property Post[] $posts
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PostCategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('app','ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['post_category_id' => 'id']);
    }
    public function getCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'post_category_id']);
    }
}
