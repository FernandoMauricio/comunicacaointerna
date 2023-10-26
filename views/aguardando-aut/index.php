<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$unidade = $_SESSION['sess_unidade'];

$this->title = 'Aguardando Autorização  ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacaointerna-com-index">

    <h3><?= Html::encode($this->title).'<small>'.$unidade.'</small>' ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover'=>true,

        'columns' => [
    [
        'class' => '\kartik\grid\ActionColumn',
        'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
    ],

            'com_codcomunicacao',
            'com_codcolaborador',
            'com_codunidade',
            'com_datasolicitacao',
            'com_titulo',
            // 'com_texto:ntext',
            // 'com_codtipo',
            // 'com_codsituacao',
            // 'com_dataautorizacao',
            // 'com_codcolaboradorautorizacao',
            // 'com_codcargoautorizacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],

        'panel' => [
        'heading'=> '<h5 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem das Comunicações Internas</h5>',
        'type'=>'primary',
    ],

    ]); ?>

</div>
