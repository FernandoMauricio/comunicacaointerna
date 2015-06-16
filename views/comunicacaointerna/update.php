<?php

use yii\helpers\Html;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = 'Atualizar e Enviar Comunicação: ' . ' ' . $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicação Interna', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>

<div class="comunicacao-interna-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-update', [
        'model' => $model,
        'destinocomunicacao' => $destinocomunicacao,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
