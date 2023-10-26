<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Despachos */

$this->title = 'Create Despachos';
$this->params['breadcrumbs'][] = ['label' => 'Despachos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachos-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'despachos' => $despachos,
    ]) ?>

</div>
