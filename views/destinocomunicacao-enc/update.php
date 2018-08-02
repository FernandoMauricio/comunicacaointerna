<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoEnc */

$this->title = 'Update Destinocomunicacao Enc: ' . ' ' . $model->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacao Encs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dest_coddestino, 'url' => ['view', 'id' => $model->dest_coddestino]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinocomunicacao-enc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'encaminhamentos' => $encaminhamentos,
    ]) ?>

</div>
