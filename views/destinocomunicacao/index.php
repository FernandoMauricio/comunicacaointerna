<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Destino Comunicação' ;
?>
<div class="destinocomunicacao-index">


<?php Pjax::begin(['id' => 'destinocomunicacaoGrid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'dest_codcomunicacao',
                'value' => 'comunicacaointerna.com_codcomunicacao',

            ],

            [
                'attribute' => 'dest_nomeunidadedest',
                'value' => 'unidades.uni_nomeabreviado',

            ],

            //'dest_coddestino',
            //'dest_codcolaborador',
            //'dest_codunidadeenvio',
            // 'dest_data',
            // 'dest_codtipo',
            // 'dest_codsituacao',

            ['class' => 'yii\grid\ActionColumn','template' => '{delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>



</div>
