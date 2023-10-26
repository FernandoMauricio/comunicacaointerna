<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AnexosModel */

$this->title = 'Update Anexos Model: ' . ' ' . $model->ane_codanexo;
$this->params['breadcrumbs'][] = ['label' => 'Anexos Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ane_codanexo, 'url' => ['view', 'id' => $model->ane_codanexo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anexos-model-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
