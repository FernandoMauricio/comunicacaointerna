<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnexosModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anexos Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anexos-model-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Anexos Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ane_codanexo',
            'ane_codcomunicacao',
            'ane_arquivo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
