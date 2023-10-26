<?php

use yii\helpers\Html;
use kartik\editable\Editable;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$unidade = $_SESSION['sess_unidade'];

$this->title = 'Aguardando Autorização  ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacaointerna-com-index">


<?php 

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}; 

?>

    <h3><?= Html::encode($this->title).'<small>'.$unidade.'</small>' ?></h3>

<br>
    
<?php

$gridColumns = [
                        [
                        'class'=>'kartik\grid\ExpandRowColumn',
                        'width'=>'50px',
                        'value'=>function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail'=>function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('/comunicacaointerna/pdf3', ['model'=>$model]);
                        },
                        'headerOptions'=>['class'=>'kartik-sheet-style'], 
                        'expandOneOnly'=>true
                        ],


                        ['attribute' => 'com_codcomunicacao',
                        'options' => ['width' => '20']
                        ],

                        ['attribute' => 'com_codcolaborador',
                        'value' => 'colaborador.usuario.usu_nomeusuario'
                        ],

                        ['attribute' => 'com_codunidade',
                        'value' => 'unidades.uni_nomecompleto'
                        ],
                        [
                            'attribute' => 'com_datasolicitacao',
                            'format' =>  ['date', 'php:d/m/Y'],
                        ],


                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{aprovar} {reprovar}',
                            'options' => ['width' => '15%'],
                            'buttons' => [

                            //----APROVAR COMUNICAÇÃO INTERNA
                            'aprovar' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-ok"></span> Aprovar', $url, [
                                            'class' => 'btn btn-success btn-xs',
                                            'title' => Yii::t('app', 'Aprovar CI'),
                                            'data'  => [
                                                'confirm' => 'Você tem CERTEZA que deseja APROVAR a CI?',
                                                'method' => 'post',
                                                 ],
                                            ]);
                                        },

                            //----REPROVAR COMUNICAÇÃO INTERNA
                            'reprovar' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-remove"></span> Reprovar', $url, [
                                            'class' => 'btn btn-danger btn-xs',
                                            'title' => Yii::t('app', 'Reprovar CI'),
                                            'data'  => [
                                                'confirm' => 'Você tem CERTEZA que deseja REPROVAR a CI?',
                                                'method' => 'post',
                                                 ],
                                            ]);
                                        },

                                ],
                        ],
                     ];


echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>false, // pjax is set to always true for this demo
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes da Comunicação Interna', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
                ['content'=>'Área de Autorizações', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
            ],
        ]
    ],

        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h5 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem das Autorizações Pendentes</h5>',
    ],
]);

 ?>

</div>
