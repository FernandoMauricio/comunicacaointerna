<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = $model->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dest_coddestino], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dest_coddestino], [
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
            'dest_coddestino',
            'dest_codcomunicacao',
            'dest_codcolaborador',
            'dest_codunidadeenvio',
            'dest_codunidadedest',
            'dest_data',
            'dest_codtipo',
            'dest_codsituacao',
            'dest_coddespacho',
            'dest_nomeunidadeenvio',
            'dest_nomeunidadedest',
            'dest_anexo',
        ],
    ]) ?>

</div>
