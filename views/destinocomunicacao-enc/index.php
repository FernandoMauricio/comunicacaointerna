<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoEncSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="destinocomunicacao-enc-index">

<?php Pjax::begin(['id' => 'destinocomunicacaoEncGrid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        //'filterModel' => $searchEncModel,
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
