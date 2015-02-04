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

    <?php $form = ActiveForm::begin(); ?>          


    <?= $form->field($model, 'com_codcolaborador')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'com_codunidade')->textInput(['readonly' => true]) ?>

    <?php 
                
                $rows = TipodocumentacaoTipdo::find()->all();
                $data = ArrayHelper::map($rows, 'tipdo_codtipo', 'tipdo_tipo');
                echo $form->field($model, 'com_codtipo')->radiolist($data);

    ?> 

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'com_texto')->textarea(['rows' => 6]) ?>
  

        <?php 
                // DropdownList
                $rows = SituacaocomunicacaoSitco::find()->all();
                $data = ArrayHelper::map($rows, 'sitco_codsituacao', 'sitco_situacao1');
                echo $form->field($model, 'com_codsituacao')->dropDownList(
                $data,
                ['prompt'=>'Selecione a Situação']
                );

    ?> 
    
    <?php //Verificar se terá que criar um campo no banco de dados da comunicaointerna e retirar a tabela de anexos.

    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'anexocomunicacaoAnes[]')->fileInput(['multiple' => true]) ?>

    <?= $form->field($model, 'com_codcolaboradorautorizacao')->textInput() ?>

    <?= $form->field($model, 'com_codcargoautorizacao')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Comunicação Interna' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>