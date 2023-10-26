<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = 'Criar Comunicação Interna';
$this->params['breadcrumbs'][] = ['label' => 'Comunicações Internas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacao-interna-com-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]); 

    ?>

</div>
