<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use app\models\SituacaodestinoSide;
use app\models\Comunicacaointerna;
use app\models\TipodocumentacaoTipdo;
use app\models\SituacaoComunicacaoSitco;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Pega as mensagens de CONFIRMAÇÃO DE DESPACHO
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

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
$unidade = $_SESSION['sess_unidade'];
$this->title = 'Despachos Pendentes ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) . '<small>Área Gerencial</small>'?></h1>

<?php

$gridColumns = [
                            [
                                'class'=>'kartik\grid\ExpandRowColumn',
                                'format' => 'raw',
                                'options' => ['width' => '2%'],
                                'value'=>function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail'=>function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('/comunicacaointerna/pdf2', ['model'=>$model]);
                                },
                                'headerOptions'=>['class'=>'kartik-sheet-style'], 
                                'expandOneOnly'=>true
                                ],

                                [
                                'attribute' => 'dest_codcomunicacao',
                                'options' => ['width' => '5%'],
                                ],                                

                                [
                                'attribute' => 'dest_nomeunidadeenvio',
                                'options' => ['width' => '5%'],
                                ],

                                [
                                    'attribute'=>'tipo', 
                                    'vAlign'=>'middle',
                                    'options' => ['width' => '10%'],
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
                                    'options' => ['width' => '10%'],
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
                                'value' => 'comunicacaointerna.com_titulo',
                                'options' => ['width' => '20%'],
                                ],

                                [
                                'attribute' => 'tag',
                                'value' => 'comunicacaointerna.com_tag',
                                'options' => ['width' => '10%'],
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {autoresp} {notificar}',
                                'options' => ['width' => '25%'],
                                'buttons' => [

                                //DESPACHAR BUTTON
                                'update' => function ($url, $model) {
                                    return $model->dest_codtipo != 4 ?  Html::a('<span class="glyphicon glyphicon-ok-circle"></span> Despachar', $url, [
                                                'title' => Yii::t('app', 'Realizar Despacho'),
                                                'class'=>'btn btn-primary btn-xs',
                               
                                    ]): '';
                                },

                                //RESPONDER "CIENTE" COM UM CLIQUE
                                'autoresp' => function ($url, $despachos) {
                                    return Html::a('<span class="glyphicon glyphicon-ok"></span> Ciente', $url, [
                                                'class'=>'btn btn-success btn-xs',
                                                'title' => Yii::t('app', 'Inserir Resposta Automática'),
                                                'data' => [
                                                                'confirm' => 'Você tem CERTEZA que deseja RESPONDER AUTOMATICAMENTE "Ciente" para essa Comunicação Interna?',
                                                                'method' => 'post',
                                                            ],

                                    ]);
                                },

                                //NOTIFICAR EQUIPE
                                'notificar' => function ($url, $model) {
                                    return $model->comunicacaointerna->com_codtipo != 2 ?  Html::a('<span class="glyphicon glyphicon-envelope"></span> Notificar', $url, [
                                                'class'=>'btn btn-warning btn-xs',
                                                'title' => Yii::t('app', 'Notificar equipe'),
                                                'data' => [
                                                                'confirm' => 'Você tem CERTEZA que deseja NOTIFICAR a equipe com os novos despachos?',
                                                                'method' => 'post',
                                                            ],

                                    ]): '';
                                },

                            ],
                            ],
                        ];


?>

    <?php Pjax::begin(['id'=>'w0-pjax']); ?>

    <?php 

    echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes da Comunicação Interna', 'options'=>['colspan'=>6, 'class'=>'text-center warning']], 
                ['content'=>'Área de Despacho', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
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