<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnidadeUniSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unidade Unis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidade-uni-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Unidade Uni', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'uni_codunidade',
            'uni_nomecompleto',
            'uni_nomeabreviado',
            'uni_cnpj',
            'uni_cep',
            // 'uni_logradouro',
            // 'uni_bairro',
            // 'uni_cidade',
            // 'uni_estado',
            // 'uni_coddisp',
            // 'uni_codtipo',
            // 'uni_codsituacao',
            // 'uni_codtipres',
            // 'uni_permitirmodeloa',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
