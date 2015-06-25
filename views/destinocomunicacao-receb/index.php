<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunicações Internas - Recebidas pelo Setor';
$this->params['breadcrumbs'][] = $this->title;
$unidade = $_SESSION['sess_unidade'];
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'panel' => [
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - '.$unidade.'</h3>',
        'type'=>'primary',
    ],
        'columns' => [
            //'dest_coddestino',
            'dest_codcomunicacao',
            //'dest_codcolaborador',
            //'dest_codunidadeenvio',
            //'dest_codunidadedest',
            //'dest_codtipo',
            //'dest_codsituacao',
            // 'dest_coddespacho',
             'dest_nomeunidadeenvio',
             'dest_data',

            [
            'attribute' => 'comunicacaointerna.com_titulo',
            'value' => 'comunicacaointerna.com_titulo'
            ],


            // 'dest_nomeunidadedest',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
