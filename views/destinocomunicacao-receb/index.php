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

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
                'rowOptions' =>function($model){
                    if($model->comunicacaointerna->com_codsituacao == '5' )
                    {

                            return['class'=>'danger'];                        
                    }
                },
        'hover' => true,
        'panel' => [
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - '.utf8_encode($unidade).'</h3>',
        'type'=>'primary',
    ],
        'columns' => [

            [
            'attribute' => 'dest_codcomunicacao',
            'width'=>'100px',
            ],
        
             'dest_nomeunidadeenvio',

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
                    'pluginOptions'=>['allowClear'=>true],
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
                'attribute'=>'situacao', 
                'vAlign'=>'middle',
                'width'=>'160px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return Html::a($model->comunicacaointerna->situacao->sitco_situacao1);
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(SituacaocomunicacaoSitco::find()->orderBy('sitco_codsituacao')->asArray()->all(), 'sitco_codsituacao', 'sitco_situacao1'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Situação'],
                'format'=>'raw'
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
