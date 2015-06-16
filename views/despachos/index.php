<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DespachosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Despachos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Despachos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'deco_coddespacho',
            'deco_codcomunicacao',
            'deco_codcolaborador',
            'deco_codunidade',
            'deco_codcargo',
            // 'deco_data',
            // 'deco_despacho:ntext',
            // 'deco_codsituacao',
            // 'deco_nomeunidade',
            // 'deco_nomeusuario',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
