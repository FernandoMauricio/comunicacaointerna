<?php

use yii\helpers\Html;
use kartik\editable\Editable;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$unidade = $_SESSION['sess_unidade'];

$this->title = 'Aguardando Autorização  ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacaointerna-com-index">

    <h1><?= Html::encode($this->title).'<small>'.$unidade.'</small>' ?></h1>

<br>

<?php 

//Get all flash messages and loop through them
foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : '',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : '',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : '',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : '',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
    
<?php

$gridColumns = [
                        [
                        'class'=>'kartik\grid\ExpandRowColumn',
                        'width'=>'50px',
                        'value'=>function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail'=>function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('/comunicacaointerna/pdf3', ['model'=>$model]);
                        },
                        'headerOptions'=>['class'=>'kartik-sheet-style'], 
                        'expandOneOnly'=>true
                        ],


                        ['attribute' => 'com_codcomunicacao',
                        'options' => ['width' => '20']
                        ],

                        ['attribute' => 'com_codcolaborador',
                        'value' => 'colaborador.usuario.usu_nomeusuario'
                        ],

                        ['attribute' => 'com_codunidade',
                        'value' => 'unidades.uni_nomeabreviado'
                        ],
                        [
                            'attribute' => 'com_datasolicitacao',
                            'format' =>  ['date', 'php:d/m/Y'],
                        ],


                      [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'com_codsituacao',
                            'value' => 'situacao.sitco_situacao1',  
                            'readonly'=>function($model, $key, $index, $widget) {
                                return (!$model->com_codsituacao); // do not allow editing of inactive records
                            },
                            //CAIXA DE AUTORIZAÇÕES
                            'editableOptions' => [
                                'header' => 'Autorizações',
                                'data'=>[4 => 'Sim', 1 => 'Não' ],
                                'options' => [
                                'class'=>'form-control', 'prompt'=>'Autorizar?',
                                ],
                                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                            ],          
                        ],
                     ];


echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>false, // pjax is set to always true for this demo
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes da Comunicação Interna', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
                ['content'=>'Área de Autorizações', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
            ],
        ]
    ],

        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem das Autorizações Pendentes</h3>',
    ],
    //'persistResize'=>false,

    // parameters from the demo form
    // 'bordered'=>$bordered,
    // 'striped'=>$striped,
    // 'condensed'=>$condensed,
    // 'responsive'=>$responsive,
    // 'hover'=>$hover,
    // 'showPageSummary'=>$pageSummary,        
    //  'heading'=>$heading,
    //'exportConfig'=>$exportConfig,
]);

 ?>

</div>
