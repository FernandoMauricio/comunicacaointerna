<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cargos */

$this->title = 'Update Cargos: ' . ' ' . $model->car_codcargo;
$this->params['breadcrumbs'][] = ['label' => 'Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->car_codcargo, 'url' => ['view', 'id' => $model->car_codcargo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cargos-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
