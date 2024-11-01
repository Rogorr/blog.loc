<?php

namespace admin\models;

use common\models\User;
use Yii;
use admin\enum\PostStatus;
use common\components\TimestampBehavior;
use yii\web\UploadedFile;


/**
 * This is the model class for table "Post".
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
 *
 * @property PostCategory $postCategory
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    
    public UploadedFile|string|null $imageFile = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'post_category_id', ], 'required'],
            [['user_id', 'post_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'in', 'range' => array_column(PostStatus::getAllStatuses(), 'value')],
            [['text'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['post_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostCategory::class, 'targetAttribute' => ['post_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe'],
            ['imageFile', 'file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' =>  Yii::t('app','User ID'),
            'title' =>  Yii::t('app','Title'),
            'text' =>  Yii::t('app','Text'),
            'post_category_id' =>  Yii::t('app','Post Category ID'),
            'status' =>  Yii::t('app','Status'),
            'image' =>  Yii::t('app','Image'),
            'created_at' =>  Yii::t('app','Created At'),
            'updated_at' =>  Yii::t('app','Updated At'),
            'imageFile' => Yii::t('app','Image')
        ];
    }

    public function beforeValidate(): bool
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool
    {
        if ($this->imageFile  instanceof UploadedFile) {
            if ($this->image) {
                
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            }
            $path = 'C:\OSPanel\home\blog.loc\htdocs\uploads\\'; 
            // $this->image = '';
            $fileName = uniqid() . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($path . $fileName)) {
                $this->image = '/uploads/' . $fileName; 
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[PostCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'post_category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getStatusLabel(): string
    {
        return PostStatus::from($this->status)->label(); 
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'title',
            'text',
            'status'=> function ($model) {
                return $model->getStatusLabel(); 
            },
            // 'image' => function() {
            //     return Yii::$app->request->hostInfo . $this->image;
            // },
            // 'post_category_id',
            'category_name' => function ($model) {
                return $model->postCategory ? $model->postCategory->name : null;
            },
            // 'status_label' => function ($model) {
            //     return $model->getStatusLabel(); 
            // },
            
        ];
        $imageValue = Yii::$app->request->post('image');
        $fields['image'] = function() use ($imageValue) {
            return !empty($imageValue) ? Yii::$app->request->hostInfo . $this->image : null;
        };
        if (!Yii::$app->request->isAjax) {
            $fields[] = [
                'category_name' => function ($model) {
                    return $model->postCategory ? $model->postCategory->name : null;
                },
            ];
        }
    
    }
}
