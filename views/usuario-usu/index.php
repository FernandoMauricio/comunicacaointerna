<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioUsuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuario Usus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-usu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usuario Usu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'usu_codusuario',
            'usu_loginusuario',
            'usu_senhausuario',
            'usu_nomeusuario',
            'usu_codtipo',
            // 'usu_codsituacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
