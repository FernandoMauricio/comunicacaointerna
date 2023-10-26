<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = 'Update Comunicacaointerna Com: ' . ' ' . $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicacaointerna Coms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->com_codcomunicacao, 'url' => ['view', 'id' => $model->com_codcomunicacao]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comunicacaointerna-com-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
