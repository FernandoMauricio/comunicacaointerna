<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaoInternaCom */

$this->title = 'Criar Comunicação Interna';
$this->params['breadcrumbs'][] = ['label' => 'Comunicação Interna', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacao-interna-com-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
