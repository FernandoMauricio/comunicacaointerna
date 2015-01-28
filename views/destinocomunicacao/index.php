<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Destino Comunicação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Destino', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
