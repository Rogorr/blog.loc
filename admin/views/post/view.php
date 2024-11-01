<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'title',
            'text:ntext',
            'post_category_id',
            'status',
            [
                'attribute' => 'image',
                'format' => 'raw', 
                'value' => function ($model) {
                    return Html::img($model->image, ['alt' => 'Image', 'style' => 'max-width: 100%; height: auto;']);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime', 
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i');
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime', 
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d.m.Y H:i');
                },
            ],
        ],
    ]) ?>

</div>
