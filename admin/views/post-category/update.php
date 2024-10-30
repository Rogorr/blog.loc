<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var admin\models\PostCategory $model */

$this->title = Yii::t('app', 'Update Post Category: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);

// $this->title = 'Update Post Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
