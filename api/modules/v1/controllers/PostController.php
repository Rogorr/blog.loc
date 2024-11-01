<?php
namespace api\modules\v1\controllers;

use admin\models\Post;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class PostController extends AppController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authentificator' => ['except' => ['get-post']]
        ]);
    }

    public function verbs() : array
     {
        return [
            'get-posts' => ['GET'],
        ];
    }


    public function actionGetPost()
    {
        $query = Post::find()->where(['status' => 20]);

        if ($id = Yii::$app->request->get('id')) {
            $post = $query->andWhere(['id' => $id])->one();
            if ($post) {

                return $this->asJson([
                    'success' => true,
                    'data' => $post->toArray([], ['status']), 
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Post not found.',
                ]);
            }
        }

        if ($userId = Yii::$app->request->get('user_id')) {
            $query->andWhere(['user_id' => $userId]);
        }

        if ($categoryId = Yii::$app->request->get('post_category_id')) {
            $query->andWhere(['post_category_id' => $categoryId]);
        }

        $firstItem = Yii::$app->request->get('first_item', 0);
        $itemCount = Yii::$app->request->get('item_count', 10);
        $query->limit($itemCount)->offset($firstItem);
        $query->orderBy(['created_at' => SORT_DESC]);

        $posts = $query->all();

        foreach ($posts as $post) {
            $post->title = $post->title;
            $post->created_at = date('d.m.Y H:i', $post->created_at);
            $post->updated_at = date('d.m.Y H:i', $post->updated_at);
        
        }

        $totalPosts = Post::find()->where(['status' => 20])->count();

        return $this->asJson([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'total' => $totalPosts,
                'first_item' => $firstItem,
                'item_count' => $itemCount,
                'total_pages' => ceil($totalPosts / $itemCount),
            ],
        ]);
    }

    public function actionCreatePost()
    {
        $postData = Yii::$app->request->post();
        
        $post = new Post();
        $post->user_id = Yii::$app->user->id; 
        $post->post_category_id = $postData['category_id'];
        $post->title = $postData['title'];
        $post->text = $postData['text'];
        $post->status = $postData['status'] ?? 0;

        if (isset($postData['image']) && !empty($postData['image'])) {
            if (preg_match('/^data:image\/(\w+);base64,/', $postData['image'], $type)) {
                $image = substr($postData['image'], strpos($postData['image'], ',') + 1);
                $image = base64_decode($image);
                $fileName = uniqid() . '.' . $type[1];
                file_put_contents('/htdocs/uploads/' . $fileName, $image);
                $post->image = $fileName;
            } else {
                $file = $postData['image'];
                if ($file['error'] == UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($file['tmp_name'], '/htdocs/uploads/' . $fileName);
                    $post->image = $fileName;
                }
            }
        }

        if ($post->save()) {
            return $this->asJson([
                'success' => true,
                'data' => $post,
            ]);
        }

        return $this->asJson([
            'success' => false,
            'errors' => $post->getErrors(),
        ]);
    }

}