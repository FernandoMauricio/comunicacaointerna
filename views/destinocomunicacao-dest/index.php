<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoDestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Destinocomunicacao Dests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-dest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Destinocomunicacao Dest', ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'dest_hora',
            // 'dest_codtipo',
            // 'dest_codsituacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
