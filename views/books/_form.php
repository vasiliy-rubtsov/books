<?php

use app\models\Authors;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var yii\widgets\ActiveForm $form */

    $photoImageTempl = '{label}'
        .Html::beginTag('div', ['class' => 'image-preview'])
        . ($model->photo ? Html::img(Yii::getAlias('@web/uploads/' . $model->photo), ['width' => 200]) : '')
        . Html::endTag('div')
        . '{input}{hint}'
        . Html::button('X', ['class' => 'image-reset', 'disabled' => true, 'title' => 'Отменить выбор'])
        . '{error}';
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorIds')->widget(Select2::class, [
        'data' =>  array_map(
            function (Authors $v): string {
                return sprintf('%s %s', $v->name, $v->surname);
            },
            $model->authorsWithId
        ),
        'language' => 'ru',
        'options' => [
            'placeholder' => 'Выберите авторов...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => Url::to(['/authors/find-by-term']),
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression('function(params) { return {term:params.term}; }'),
                'processResults' => new JsExpression('function(data) { return {results: data.items}; }'),
            ]
        ],
    ])->label('Authors') ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'photoImage', [
        'template' => $photoImageTempl,
        'options' => [
            'class' => 'image-input',
        ]
    ])->fileInput([
        'hiddenOptions' => [
            'name' => Html::getInputName($model, 'photo'),
            'value' => Html::getAttributeValue($model, 'photo')
        ]
    ])->label(Yii::t('app', 'Photo')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
