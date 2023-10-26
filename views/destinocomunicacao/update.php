<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = 'Update Destinocomunicacao: ' . ' ' . $model->dest_coddestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dest_coddestino, 'url' => ['view', 'id' => $model->dest_coddestino]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinocomunicacao-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
