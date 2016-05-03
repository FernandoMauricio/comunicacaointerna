<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = 'Create Destinocomunicacao';
$this->params['breadcrumbs'][] = ['label' => 'Destinocomunicacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
