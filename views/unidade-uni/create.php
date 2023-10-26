<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Unidade_uni */

$this->title = 'Create Unidade Uni';
$this->params['breadcrumbs'][] = ['label' => 'Unidade Unis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidade-uni-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
