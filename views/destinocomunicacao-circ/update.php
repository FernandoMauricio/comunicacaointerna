<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

//$this->title = 'Update Destinocomunicacao: ' . ' ' . $model->dest_coddestino;
$this->title = 'Área de Despacho' . '';
$this->params['breadcrumbs'][] = ['label' => 'Despachos Pendentes ', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->dest_coddestino, 'url' => ['view', 'id' => $model->dest_coddestino]];
$this->params['breadcrumbs'][] = 'Área de Despacho';
?>
<div class="destinocomunicacao-update">

    <h1><?= Html::encode($this->title) . '<small> Comunicação Interna: ' . $despachos->deco_codcomunicacao .'</small>' ?></h1>


    <?= $this->render('_form', [
        'encaminhamentos' => $encaminhamentos,
        'model' => $model,
        'despachos' => $despachos,
    ]) ?>

   <?= $this->render('pendentes', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

    <?= $this->render('/comunicacaointerna/pdf2', [
        'model' => $model,
        'despachos' => $despachos,
    ]) ?>

</div>
