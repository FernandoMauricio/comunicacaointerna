<!DOCTYPE html>
<!-- release v4.1.8, copyright 2014 - 2015 Kartik Visweswaran -->
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/kartik-v/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../vendor/kartik-v/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" type="text/javascript"></script>
    </head>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\helpers\ArrayHelper;
use app\models\SituacaocomunicacaoSitco;
use app\models\TipodocumentacaoTipdo;
use app\models\ComunicacaoInternaCom;
use app\models\DespachocomunicacaoDeco;


/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaoInternaCom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comunicacao-interna-com-form">
<br>
    <?php $form = ActiveForm::begin(); ?>          


    <?php // $form->field($model, 'com_codcolaborador')->textInput(['readonly'=>true]) ?>

    <?php // $form->field($model, 'com_codunidade')->textInput(['readonly' => true]) ?>

    <?php 
                
                $rows = TipodocumentacaoTipdo::find()->all();
                $data = ArrayHelper::map($rows, 'tipdo_codtipo', 'tipdo_tipo');
                echo $form->field($model, 'com_codtipo')->radiolist($data);

    ?> 

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'com_texto')->textarea(['rows' => 6]) ?>
  
    <?= $form->field($model, 'com_codsituacao')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'com_codsituacao')->textInput(['value'=>4,'readonly'=>true]) ?>


        <?php 
                // DropdownList SITUAÇÃO
   /*             $rows = SituacaocomunicacaoSitco::find()->all();
                $data = ArrayHelper::map($rows, 'sitco_codsituacao', 'sitco_situacao1');
                echo $form->field($model, 'com_codsituacao')->dropDownList(
                $data,
                ['prompt'=>'Selecione a Situação']
                );
*/
    ?>


                <div class="form-group">
                    <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                </div>

    <?php 

 //Verificar se terá que criar um campo no banco de dados da comunicaointerna e retirar a tabela de anexos.
 
    //AUTORIZAÇÃO GERENTE - VERIFICAR COMO INSERIR OS DADOS SE A CI FICAR PARA AUTORIZAÇÃO

    //$form->field($model, 'com_codcolaboradorautorizacao')->textInput() ?>

    <?php //$form->field($model, 'com_codcargoautorizacao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Comunicação Interna' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

    <script>
    $("#file-0").fileinput({
        'allowedFileExtensions' : ['jpg', 'png','gif','zip'],
    });
    $("#file-1").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif','zip'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
    </script>
 