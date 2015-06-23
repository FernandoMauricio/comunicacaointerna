<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'dest_codcomunicacao')->textInput(['maxlength' => 10]) ?>

    <?php //echo $form->field($model, 'dest_codcolaborador')->textInput() ?>

    <?php //echo $form->field($model, 'dest_codunidadeenvio')->textInput() ?>

    <?php //echo $form->field($model, 'dest_codtipo')->textInput(['maxlength' => 10]) ?>

    <?php //echo $form->field($model, 'dest_codsituacao')->textInput(['maxlength' => 10]) ?>

<!-- Render create form -->    
   <?= $this->render('/despachos/_form', [
        'despachos' => $despachos,
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
