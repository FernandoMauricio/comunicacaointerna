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

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form-update', [
        'model' => $model,
        'destinocomunicacao' => $destinocomunicacao,
    ]) ?>

</div>

