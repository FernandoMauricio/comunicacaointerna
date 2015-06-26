<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Pega as mensagens de CONFIRMAÇÃO DE DESPACHO
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

$unidade = $_SESSION['sess_unidade'];
$this->title = 'Despachos Pendentes ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) . '<small>Área Gerencial</small>'?></h1>

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

            'dest_codcomunicacao',
            'dest_nomeunidadeenvio',
            //'dest_data',
            [
            'attribute' => 'comunicacaointerna.com_datasolicitacao',
            'format' =>  ['date', 'php:d/m/Y H:i:s'],
            ],
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

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [

            //view button
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-ok-circle"></span> Despachar', $url, [
                            'class'=>'btn btn-primary btn-xs',                                  
                ]);
            },
        ],
        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
