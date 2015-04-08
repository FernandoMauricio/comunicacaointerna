<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Destinocomunicacao;
use app\models\ComunicacaointernaCom;


/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */

$this->title = 'Enviar Comunicação Interna: ' . ' ' . $model->dest_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Enviar Comunicação Interna', 'url' => ['comunicacaointerna/index']];
$this->params['breadcrumbs'][] = ['label' => $model->dest_codcomunicacao, 'url' => ['comunicacaointerna/view', 'id' => $model->dest_codcomunicacao]];
?>
<div class="destinocomunicacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
