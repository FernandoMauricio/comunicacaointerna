<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DespachocomunicacaoDeco */

$this->title = 'Create Despachocomunicacao Deco';
$this->params['breadcrumbs'][] = ['label' => 'Despachocomunicacao Decos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachocomunicacao-deco-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
