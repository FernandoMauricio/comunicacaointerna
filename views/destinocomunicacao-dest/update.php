<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoDest */

$this->title = 'Update Destinocomunicacao Dest: ' . ' ' . $model->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacao Dests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dest_coddestino, 'url' => ['view', 'id' => $model->dest_coddestino]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinocomunicacao-dest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
