<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var yii\widgets\ActiveForm $form */

    //$photoImageTempl = "{label}\n{hint}\n{error}\n";

    $photoImageTempl = '{label}'
        .Html::beginTag('div', ['class' => 'image-preview'])
        . ($model->photo ? Html::img(Yii::getAlias('@web/uploads/' . $model->photo), ['width' => 200]) : '')
        . Html::endTag('div')
        . '{input}{hint}'
        . Html::button('X', ['class' => 'image-clear', 'disabled' => true])
        . '{error}';



?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'photoImage', [
        'template' => $photoImageTempl,
        'options' => [
            'class' => 'image-input',
        ]
    ])->fileInput()->label(Yii::t('app', 'Photo')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
