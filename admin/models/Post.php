<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id ID Пользователя, создавшего пост
 * @property string $title Заголовок
 * @property string $text Текст
 * @property int $post_category_id ID категории
 * @property int $status Статус публикации: brandnew / published / rejected
 * @property string|null $image Изображение (можно хранить строку с путем до изображения)
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'text', 'post_category_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'post_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['post_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostCategory::class, 'targetAttribute' => ['post_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'text' => 'Text',
            'post_category_id' => 'Post Category ID',
            'status' => 'Status',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
