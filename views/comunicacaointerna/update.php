<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaoInternaCom */

$this->title = 'Atualizar Comunicação: ' . ' ' . $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicação Interna', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->com_codcomunicacao, 'url' => ['view', 'id' => $model->com_codcomunicacao]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comunicacao-interna-com-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
