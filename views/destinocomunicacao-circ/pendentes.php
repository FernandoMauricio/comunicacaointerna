<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
.pull-right {display: none;}
</style>
<div class="destinocomunicacao-index">


<?php

?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,
        'panel' => [
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Restam a Despachar</h3>',
        'before' => '<em>Listagem de Unidades/Setores que ainda não despacharam</em>',
        'type'=>'danger',
    ],
        'columns' => [

             ['attribute' => 'dest_nomeunidadedest',
             'label' => 'Unidades Pendentes',
             ]

        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
