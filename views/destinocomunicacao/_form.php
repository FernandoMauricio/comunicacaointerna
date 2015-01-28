<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SituacaodestinoSide;
use app\models\Destinocomunicacao;
use app\models\Tipodestino;
use app\models\Unidade_uni;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dest_codcomunicacao')->textInput(['readonly'=>true]) ?>


    <?= $form->field($model, 'dest_codcolaborador')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'dest_codunidadeenvio')->textInput(['readonly'=>true]) ?>
                    <?php 
                // DropdownList Tipo de Destino da comunicação para o envio
                $rows = Tipodestino::find()->all();
                $data = ArrayHelper::map($rows, 'tipde_codtipo', 'tipde_descricao');
                echo $form->field($model, 'dest_codtipo')->dropDownList(
                $data,
                ['prompt'=>'Selecione a Situação']
                );

    ?>    

    <?php 
                // DropdownList Situação da comunicação para o envio e despacho
                $rows = SituacaodestinoSide::find()->all();
                $data = ArrayHelper::map($rows, 'side_codsituacao', 'side_situacao');
                echo $form->field($model, 'dest_codsituacao')->dropDownList(
                $data,
                ['prompt'=>'Selecione a Situação']
                );

    ?> 

        <?php 
                // DropdownList Listagem de Unidades
                $rows = Unidade_uni::find()->all();
                $data = ArrayHelper::map($rows, 'uni_codunidade', 'uni_nomeabreviado');
                echo $form->field($model, 'dest_codunidadedest')->dropDownList(
                $data,
                ['prompt'=>'Selecione a Situação']
                );

    ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
