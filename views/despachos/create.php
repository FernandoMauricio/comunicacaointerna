<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Despachos */

$this->title = 'Create Despachos';
$this->params['breadcrumbs'][] = ['label' => 'Despachos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'despachos' => $despachos,
    ]) ?>

</div>
