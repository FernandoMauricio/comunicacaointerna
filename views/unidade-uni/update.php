<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unidade_uni */

$this->title = 'Update Unidade Uni: ' . ' ' . $model->uni_codunidade;
$this->params['breadcrumbs'][] = ['label' => 'Unidade Unis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uni_codunidade, 'url' => ['view', 'id' => $model->uni_codunidade]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unidade-uni-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
