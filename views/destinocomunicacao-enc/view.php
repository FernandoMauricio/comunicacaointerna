<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoEnc */

$this->title = $encaminhamentos->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacao Encs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-enc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $encaminhamentos->dest_coddestino], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $encaminhamentos->dest_coddestino], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'encaminhamentos' => $encaminhamentos,
        'attributes' => [
            'dest_coddestino',
            'dest_codcomunicacao',
            'dest_codcolaborador',
            'dest_codunidadeenvio',
            'dest_data',
            'dest_codtipo',
            'dest_codsituacao',
            'dest_coddespacho',
            'dest_nomeunidadeenvio',
            'dest_nomeunidadedest',
        ],
    ]) ?>

</div>
