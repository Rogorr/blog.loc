<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use admin\enum\PostStatus

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_category_id')->textInput() ?>

    <!-- <?= $form->field($model, 'status')->textInput() ?> -->
    <?= $form->field($model, 'status')->dropDownList(
    array_column(PostStatus::getAllStatuses(), 'label', 'value'),
    ['prompt' => 'Выберите статус']
    ) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
