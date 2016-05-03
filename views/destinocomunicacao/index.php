<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Destinocomunicacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Destinocomunicacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dest_coddestino',
            'dest_codcomunicacao',
            'dest_codcolaborador',
            'dest_codunidadeenvio',
            'dest_codunidadedest',
            // 'dest_data',
            // 'dest_codtipo',
            // 'dest_codsituacao',
            // 'dest_coddespacho',
            // 'dest_nomeunidadeenvio',
            // 'dest_nomeunidadedest',
            // 'dest_anexo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
