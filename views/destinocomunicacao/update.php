<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = 'Update Destinocomunicacao: ' . ' ' . $destinocomunicacao->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $destinocomunicacao->dest_coddestino, 'url' => ['view', 'id' => $destinocomunicacao->dest_coddestino]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinocomunicacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'destinocomunicacao' => $destinocomunicacao,
    ]) ?>

</div>
