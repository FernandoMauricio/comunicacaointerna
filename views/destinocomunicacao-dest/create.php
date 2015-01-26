<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoDest */

$this->title = 'Create Destinocomunicacao Dest';
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacao Dests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-dest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
