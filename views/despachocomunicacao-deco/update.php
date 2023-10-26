<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DespachocomunicacaoDeco */

$this->title = 'Update Despachocomunicacao Deco: ' . ' ' . $model->deco_coddespacho;
$this->params['breadcrumbs'][] = ['label' => 'Despachocomunicacao Decos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deco_coddespacho, 'url' => ['view', 'id' => $model->deco_coddespacho]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="despachocomunicacao-deco-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
