<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Despachos Pendentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'dest_codcomunicacao',
            'dest_nomeunidadeenvio',
            'dest_data',
            //'dest_codsituacao',
            [
            'attribute' => 'comunicacaointerna.com_titulo',
            'value' => 'comunicacaointerna.com_titulo'
            ],

            //'dest_codcolaborador',
            //'dest_codunidadeenvio',
            //'dest_codunidadedest',
            //'dest_coddestino',
            // 'dest_codtipo',
            // 'dest_coddespacho',
            // 'dest_nomeunidadedest',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
