<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Despachos */

$this->title = 'Update Despachos: ' . ' ' . $model->deco_coddespacho;
$this->params['breadcrumbs'][] = ['label' => 'Despachos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deco_coddespacho, 'url' => ['view', 'id' => $model->deco_coddespacho]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="despachos-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
