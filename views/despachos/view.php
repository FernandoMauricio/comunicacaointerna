<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Despachos */

$this->title = $model->deco_coddespacho;
$this->params['breadcrumbs'][] = ['label' => 'Despachos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->deco_coddespacho], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->deco_coddespacho], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'deco_coddespacho',
            'deco_codcomunicacao',
            'deco_codcolaborador',
            'deco_codunidade',
            'deco_codcargo',
            'deco_data',
            'deco_despacho:ntext',
            'deco_codsituacao',
            'deco_nomeunidade',
            'deco_nomeusuario',
        ],
    ]) ?>

</div>
