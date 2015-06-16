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

$unidade = $_SESSION['sess_unidade'];


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

/*  OUTRO EXEMPLO QUE POSSO USAR:          [
                'header' => 'Criado Por',
                'attribute' => 'com_codcolaborador',
                'value' => function ($data) {
                return $data->colaborador->usuario->usu_nomeusuario;
                },
             ],*/
            [
                'attribute' => 'com_codtipo',
                'value' => 'comCodtipo.tipdo_tipo',
                'width'=>'130px'
            ],

/*            [
                'attribute' => 'com_codunidade',
                'value' => 'unidade.uni_nomeabreviado'
            ],


            [
                'attribute' => 'com_datasolicitacao',
                'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            ],*/

            'com_titulo',

            
/*            [
                'attribute' => 'com_codcolaboradorautorizacao',
                'value' => 'colaboradorAutorizacao.usuario.usu_nomeusuario'
            ],
*/

            [
                'attribute' => 'com_codsituacao',
                'value' => 'situacao.sitco_situacao1',
                'width'=>'180px'

            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
        ],

    ]);

     ?>

<?php Pjax::end(); ?>
</div>
