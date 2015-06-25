<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
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

        <?= $this->render('/comunicacaointerna/pdf', [
        'model' => $model,
        //'destinocomunicacao' => $destinocomunicacao,
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
