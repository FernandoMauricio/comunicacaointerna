<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unidade_uni */

$this->title = $model->uni_codunidade;
$this->params['breadcrumbs'][] = ['label' => 'Unidade Unis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidade-uni-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->uni_codunidade], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->uni_codunidade], [
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
            'uni_codunidade',
            'uni_nomecompleto',
            'uni_nomeabreviado',
            'uni_cnpj',
            'uni_cep',
            'uni_logradouro',
            'uni_bairro',
            'uni_cidade',
            'uni_estado',
            'uni_coddisp',
            'uni_codtipo',
            'uni_codsituacao',
            'uni_codtipres',
            'uni_permitirmodeloa',
        ],
    ]) ?>

</div>
