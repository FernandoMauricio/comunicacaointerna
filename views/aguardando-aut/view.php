<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicacaointerna Coms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacaointerna-com-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->com_codcomunicacao], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->com_codcomunicacao], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'com_codcomunicacao',
            'com_codcolaborador',
            'com_codunidade',
            'com_datasolicitacao',
            'com_titulo',
            'com_texto:ntext',
            'com_codtipo',
            'com_codsituacao',
            'com_dataautorizacao',
            'com_codcolaboradorautorizacao',
            'com_codcargoautorizacao',
        ],
    ]) ?>

</div>
