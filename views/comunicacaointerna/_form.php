<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaoInternaCom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comunicacao-interna-com-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'com_codtipo')->radio(['com_codtipo'=>'Confidencial']); ?>

    <?= $form->field($model, 'com_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'com_codunidade')->textInput() ?>

    <?= $form->field($model, 'com_datasolicitacao')->textInput() ?>

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'com_texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'com_codsituacao')->dropDownList(['label' => 'Escolha a situação:', 'Em Elaboração']);  ?> 

    <?= $form->field($model, 'com_dataautorizacao')->textInput() ?>

    <?= $form->field($model, 'com_codcolaboradorautorizacao')->textInput() ?>

    <?= $form->field($model, 'com_codcargoautorizacao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Comunicação Interna' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
