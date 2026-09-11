<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Authors;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Authors',
                'format' => 'raw',
                'value' => function ($model) {
                    return implode(
                        ',<br/>',
                        array_map(
                            function (Authors $v): string {
                                return sprintf('%s %s', $v->name, $v->surname);
                            },
                            $model->authors
                        )
                    );
                }
            ],
            'title',
            'isbn',
            'year',
            'annotation:ntext',
            [
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@web/uploads/' . $model->photo), ['width' =>  200]);
                }
            ],
        ],
    ]) ?>

</div>
