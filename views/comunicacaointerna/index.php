<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\UnidadeUni;
use app\models\UnidadeUniSearch;
use app\models\Unidade_uni;
use app\models\app\models\UsuarioUsu;
use app\models\Comunicacaointerna;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\db\ActiveQuery;
use yii\db\Connection;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;
$unidade = $session['sess_unidade'];


//Pega as mensagens de EXCLUSÃO DE CI
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

$this->title = 'Comunicações Internas ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comunicacao-interna-com-index">

    <h1><?= Html::encode($this->title) . '<small>Criadas pelo Setor</small>' ?></h1>

<br>
    <p>
        <?= Html::a('Nova Comunicacao Interna', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' =>function($model){
                    if($model->com_codsituacao == '5' )
                    {

                            return['class'=>'danger'];                        
                    }


        },

        'hover' => true,

        'panel' => [
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - '.$unidade.'</h3>',
        'type'=>'primary',
    ],


        'columns' => [
            [
            'attribute'=>'com_codcomunicacao',
            'width'=>'5px'
            ],

            [
                'attribute' => 'com_codtipo',
                'value' => 'comCodtipo.tipdo_tipo',
                'width'=>'130px'
            ],

             [
                'attribute' => 'com_titulo',
                'value' => function ($data) {

                    $session = Yii::$app->session;      

                    if($data->com_codtipo == '1'  )
                {
                return $data->com_titulo;
                }else{
                    return '****CONFIDENCIAL****';
                }
                },
             ],
            [
                'attribute' => 'com_datasolicitacao',
                'format' => ['date', 'php:d/m/Y'],
                'width'=>'130px',
            ],
            
            [
                'attribute' => 'com_codsituacao',
                'value' => 'situacao.sitco_situacao1',
                'width'=>'180px'

            ],


                ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {encerrar} {delete} ',
                'options' => ['width' => '150px'],
                'buttons' => [

                //FINALIZAR CI
                'encerrar' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', $url, [
                                'data' => [
                                                'confirm' => 'Você tem CERTEZA que deseja ENCERRAR essa Comunicação Interna?',
                                                'method' => 'post',
                                            ],
                    ]);
                },

                ],
            ],
        ],

    ]);

     ?>

<?php Pjax::end(); ?>
</div>
