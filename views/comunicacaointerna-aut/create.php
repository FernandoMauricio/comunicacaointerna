<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = 'Create Comunicacaointerna Com';
$this->params['breadcrumbs'][] = ['label' => 'Comunicacaointerna Coms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacaointerna-com-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
