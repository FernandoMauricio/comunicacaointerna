<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\SituacaodestinoSide;
use app\models\Comunicacaointerna;

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
                                'width'=>'50px',
                                'value'=>function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail'=>function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('/comunicacaointerna/pdf2', ['model'=>$model]);
                                },
                                'headerOptions'=>['class'=>'kartik-sheet-style'], 
                                'expandOneOnly'=>true
                                ],

                                'dest_codcomunicacao',
                                'dest_nomeunidadeenvio',
                                [
                                'attribute' => 'comunicacaointerna.com_datasolicitacao',
                                'format' =>  ['date', 'php:d/m/Y H:i:s'],
                                ],

                                [
                                'attribute' => 'comunicacaointerna.com_titulo',
                                'value' => 'comunicacaointerna.com_titulo'
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {encerrar}',
                                'buttons' => [

                                //DESPACHAR BUTTON
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-ok-circle"></span> Despachar', $url, [
                                                'class'=>'btn btn-primary btn-xs',
                               
                                    ]);
                                },


                                //FINALIZAR CI
                                'encerrar' => function ($url, $comunicacaointerna) {
                                    return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Finalizar CI', $url, [
                                                'class'=>'btn btn-danger btn-xs',
                                                'data' => [
                                                                'confirm' => 'Você tem CERTEZA que deseja ENCERRAR essa Comunicação Interna?',
                                                                'method' => 'post',
                                                            ],
                                    ]);
                                },
                            ],
                            ],
                        ];


?>

    <?php Pjax::begin(); ?>

    <?php 

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
                ['content'=>'Área de Despacho', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
            ],
        ]
    ],

        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - '.$unidade.'</h3>',
    ],
]);
    ?>
    <?php Pjax::end(); ?>

</div>