<!DOCTYPE html>
<!-- release v4.1.8, copyright 2014 - 2015 Kartik Visweswaran -->
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <link href="../vendor/kartik-v/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
        <script src="../vendor/kartik-v/bootstrap-fileinput/js/1.11.0/jquery.min.js"></script>
        <script src="../vendor/kartik-v/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    </head>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\helpers\ArrayHelper;
use app\models\AnexosModel;
use app\models\SituacaocomunicacaoSitco;
use app\models\TipodocumentacaoTipdo;
use app\models\Comunicacaointerna;
use app\models\SituacaodestinoSide;
use app\models\Destinocomunicacao;
use app\models\Tipodestino;
use app\models\Unidades;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */
/* @var $form yii\widgets\ActiveForm */

$dest_codunidadeenvio =  $_SESSION['sess_codunidade'];
$dest_codcolaborador = $_SESSION['sess_codcolaborador'];


?>

<div class="comunicacao-interna-form">
<br>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>          


    <?php // $form->field($model, 'com_codcolaborador')->textInput(['readonly'=>true]) ?>

    <?php // $form->field($model, 'com_codunidade')->textInput(['readonly' => true]) ?>

    <?php
                 
                $rows = TipodocumentacaoTipdo::find()->all();
                $data = ArrayHelper::map($rows, 'tipdo_codtipo', 'tipdo_tipo');
                echo $form->field($model, 'com_codtipo')->radiolist($data);

    ?> 

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100, 'placeholder' => 'Insira o Título...'])?>

    <?= $form->field($model, 'com_texto')->widget(CKEditor::className(), [
        'options' => ['rows' => 6, 'placeholder' => 'Insira seu Despacho...'],
        'preset' => 'basic'
    ]) ?>
    
    <?= $form->field($model, 'nomesituacao')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'com_codsituacao')->hiddenInput()->label(false); ?>

    <?php 

/*                // Usage with ActiveForm and model
            echo $form->field($model, 'file')->widget(FileInput::classname(), [
                //'options' => ['accept' => 'image/*'],
            ]);
*/

           // echo $form->field($model, 'file')->fileInput() 

            ?>


    <div class="form-group">
        
        <?php //Html::button('Criar Comunicação Interna', ['value'=>Url::to('index.php?r=destinocomunicacao%2Fcreate'), 'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Criar Comunicação Interna' : 'Enviar Comunicação Interna', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
