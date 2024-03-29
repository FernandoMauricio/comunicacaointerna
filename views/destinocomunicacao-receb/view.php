<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
$session = Yii::$app->session;
$this->title = $model->dest_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicações Internas - Recebidas pelo Setor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-view">
	
    <h3><?= Html::encode($this->title) ?></h3>
    <p>

    <?php
/**
 * THE VIEW BUTTON
 */
echo Html::a('<i class="fa glyphicon glyphicon-print"></i> Imprimir', ['/comunicacaointerna/imprimir','id' => $model->dest_codcomunicacao], [
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
