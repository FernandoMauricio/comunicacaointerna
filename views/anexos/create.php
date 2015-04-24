<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AnexosModel */

$this->title = 'Create Anexos Model';
$this->params['breadcrumbs'][] = ['label' => 'Anexos Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anexos-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
