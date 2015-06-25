<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = $model->dest_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicações Internas - Recebidas pelo Setor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-view">
	
    <h1><?= Html::encode($this->title) ?></h1>
    <p>

    <?php
/**
 * THE VIEW BUTTON
 */
echo Html::a('<i class="fa glyphicon glyphicon-print"></i> Imprimir', ['/comunicacaointerna/pdf'], [
    'class'=>'btn btn-info', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>' Clique aqui para gerar um arquivo PDF'
]);

    ?>
        <?= $this->render('/comunicacaointerna/pdf2', [
        'model' => $model,
 	   ]) ?>

</div>
