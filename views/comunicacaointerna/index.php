<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunicação Interna';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacao-interna-com-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nova Comunicacao Interna', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'com_codcomunicacao',
            //'com_codcolaborador',
            'com_codunidade',
            'com_datasolicitacao',
            'com_titulo',
            // 'com_texto:ntext',
            // 'com_codtipo',
             'com_codsituacao',
            // 'com_dataautorizacao',
            // 'com_codcolaboradorautorizacao',
            // 'com_codcargoautorizacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
