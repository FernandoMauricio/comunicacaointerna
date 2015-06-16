<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */

$this->title = $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicação Interna', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacao-interna-com-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>

    <?php
/**
 * THE VIEW BUTTON
 */
echo Html::a('<i class="fa glyphicon glyphicon-print"></i> Imprimir', ['/comunicacaointerna/pdf'], [
    'class'=>'btn btn-info', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>' Clique aqui para gerar um arquivo PDF'
]);

    ?>

<br><br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'com_codcomunicacao',

            //Tipo
            //'com_codtipo',
            [
            'label' => 'Tipo',
            'value' => $model->comCodtipo->tipdo_tipo
            ],

            //Colaborador
            //'com_codcolaborador',
            [
            'label' => 'Criado Por',
            'value' => $model->colaborador->usuario->usu_nomeusuario,
            ],

            //Unidade
            //'com_codunidade',
             [
                'label' => 'Unidade',
                'value' => $model->unidades->uni_nomeabreviado,

             ],

            [
                'attribute' => 'com_datasolicitacao',
                'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            ],
            'com_titulo',
            'com_texto:ntext',

            //Situação da CI
            //'com_codsituacao',
            [
            'label' => 'Situação',
            'value' => $model->situacao->sitco_situacao1
            ],

            //'com_codcolaboradorautorizacao',
            [
            'label' => 'Autorizado Por',
            'value' => $model->colaborador->usuario->usu_nomeusuario,
            ],

            //'com_codcargoautorizacao',
/*            [
                'label' => 'Cargo',
                'value' => $model->cargo->car_cargo,

             ],*/
             

            // [
            //     'attribute' => 'com_dataautorizacao',
            //     'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            // ],
        ],
        
    ]) ?>

<?php
//GET ANEXOS
    $files=\yii\helpers\FileHelper::findFiles('uploads/');
    if (isset($files[0])) {
        foreach ($files as $index => $file) {
            $nameFicheiro = substr($file, strrpos($file, '/') + 1);
            echo Html::a($nameFicheiro, Url::base().'/uploads/'. $model->com_codcomunicacao) . "<br/>" . "<br/>" ; // render do ficheiro no browser
        }
    } else {
        echo "Não existem arquivos disponíveis para download.";
    }
?>

</div>
