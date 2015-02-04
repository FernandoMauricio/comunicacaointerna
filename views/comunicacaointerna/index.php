<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\UnidadeUni;
use app\models\UnidadeUniSearch;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunicação Interna - Criadas pelo setor';
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
            //['class' => 'yii\grid\SerialColumn'], -> Contagem de linhas onde fica o "#"

            'com_codcomunicacao',
            //'com_codcolaborador',
             [
                'header' => 'Tipo',
                'value' => function ($data) {
                return $data->comCodtipo->tipdo_tipo;
                },
             ],
            //'com_codtipo',
             /*[
                'header' => 'Unidade',
                'value' => function ($data) {
                return $data->nome;
                },
             ],*/
            'com_codunidade',

            [
                'attribute' => 'com_datasolicitacao',
                'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            ],
            'com_titulo',
            // 'com_texto',
            // 'com_codsituacao',
            // 'com_dataautorizacao',
            // 'com_codcolaboradorautorizacao',
            // 'com_codcargoautorizacao',
             [
                'header' => 'Situação',
                'value' => function ($data) {
                return $data->comCodsituacao->sitco_situacao1;
                },
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);

     ?>

</div>
