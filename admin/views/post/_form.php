<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use admin\enum\PostStatus;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;



/** @var yii\web\View $this */
/** @var admin\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
/** @var $categoryList array*/

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'user_id')->textInput() ?> -->

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?> -->

    <?php echo $form->field($model, 'text')->widget(CKEditor::className(),[
    'editorOptions' => [
        'preset' => 'full',
        'inline' => false, 
    ],
    ]); ?>
    
    <!-- <?= $form->field($model, 'post_category_id')->textInput() ?> -->
    <?= $form->field($model, 'post_category_id')->dropDownList(
        $categoryList,
        ['prompt' => 'Выберите категорию']
    ) ?>

    <!-- <?= $form->field($model, 'status')->textInput() ?> -->
    <?= $form->field($model, 'status')->dropDownList(
    array_column(PostStatus::getAllStatuses(), 'label', 'value'),
    ['prompt' => 'Выберите статус']
    ) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


