<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\TipodocumentacaoTipdo;
use app\models\SituacaocomunicacaoSitco;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunicações Internas ';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$unidade = $session['sess_unidade'];
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title). '<small>Recebidas pelo Setor</small>' ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id' => 'w0-pjax']); ?>

    <?php

$gridColumns = [

            [
            'attribute' => 'dest_codcomunicacao',
            'width'=>'100px',
            ],
        
             [
              'attribute'=>'dest_nomeunidadeenvio',
              'width'=>'30%',
             ],

            [
                'attribute'=>'tipo', 
                'vAlign'=>'middle',
                'width'=>'160px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return Html::a($model->comunicacaointerna->comCodtipo->tipdo_tipo);
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(TipodocumentacaoTipdo::find()->orderBy('tipdo_codtipo')->asArray()->all(), 'tipdo_tipo', 'tipdo_tipo'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true, 'width' => '100px'],
                ],
                'filterInputOptions'=>['placeholder'=>'Tipo'],
                'format'=>'raw'
            ],


            [
                'attribute' => 'data_solicitacao',
                'value' => 'comunicacaointerna.com_datasolicitacao',
                'format' => ['datetime', 'php:d/m/Y'],
                'width' => '190px',
                'hAlign' => 'center',
                'filter'=> DatePicker::widget([
                'model' => $searchModel, 
                'attribute' => 'data_solicitacao',
                'pluginOptions' => [
                     'autoclose'=>true,
                     'format' => 'yyyy-mm-dd',
                ]
            ])
            ],

            [
               'attribute' => 'titulo',
               'width'=>'50%',
               'value' => function ($data) {

                   $session = Yii::$app->session;      

                   if($data->comunicacaointerna->com_codtipo == '1'  )
               {
               return $data->comunicacaointerna->com_titulo;
               }else{
                   return '****CONFIDENCIAL****';
               }
               },
            ],

            [
                'attribute' => 'tag',
                'value' => 'comunicacaointerna.com_tag',
                'options' => ['width' => '10%'],
            ],

            [
                'attribute'=>'situacao', 
                'vAlign'=>'middle',
                'width'=>'160px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return Html::a($model->comunicacaointerna->situacao->sitco_situacao1);
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(SituacaocomunicacaoSitco::find()->orderBy('sitco_codsituacao')->asArray()->all(), 'sitco_codsituacao', 'sitco_situacao1'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true, 'width' => '100px'],
                ],
                'filterInputOptions'=>['placeholder'=>'Situação'],
                'format'=>'raw'
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
    ]; 

    ?>

    <?php Pjax::begin(['id'=>'w0-pjax']); ?>

    <?php 

    echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'rowOptions' =>function($model){
                if($model->comunicacaointerna->com_codsituacao == '5' )
                {

                        return['class'=>'danger'];                        
                }


    },
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    'condensed' => true,
    'hover' => true,
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes da Comunicação Interna - Recebidas pelo Setor', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
                ['content'=>'Ações', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
            ],
        ]
    ],

        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - '.utf8_encode($unidade).'</h3>',
    ],
]);
    ?>
    <?php Pjax::end(); ?>

</div>

