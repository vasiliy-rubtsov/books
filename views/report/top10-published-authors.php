<?php
/**
 * @var yii\web\View $this
 * @var $model app\models\ReportParametersForm
 * @var $result array|null
 * @var $years array
 * @var $show bool
 */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<h1><?= Yii::t('app', 'Top 10 most published authors'); ?></h1>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'year')->dropDownList($years); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Generate report'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php if ($show): ?>
    <h2><?= $model->year ?></h2>

    <?php if ($result): ?>
        <?= Html::beginTag('table', ['class' => 'table table-striped table-bordered']) ?>
        <?= Html::beginTag('thead') ?>
        <?= Html::beginTag('tr') ?>
        <?= Html::tag('th', Yii::t('app', 'Author')) ?>
        <?= Html::tag('th', Yii::t('app', 'Number books published')) ?>
        <?= Html::endTag('tr') ?>
        <?= Html::endTag('thead') ?>

        <?= Html::beginTag('tbody') ?>

        <?php  foreach ($result as $item): ?>
            <?= Html::beginTag('tr') ?>
            <?= Html::tag('td', Html::encode(sprintf('%s %s', $item['name'], $item['surname']))) ?>
            <?= Html::tag('td', Html::encode($item['cnt'])) ?>
            <?= Html::endTag('tr') ?>
        <?php endforeach;?>

        <?= Html::endTag('tbody') ?>
        <?= Html::endTag('table') ?>
    <?php else: ?>
        <h3><?= Yii::t('app', 'There is no information for this year.') ?></h3>
    <?php endif; ?>
<?php endif; ?>
