<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //echo $form->field($model, 'dest_codcomunicacao')->textInput(['maxlength' => 10]) ?>

    <?php //echo $form->field($model, 'dest_codcolaborador')->textInput() ?>

    <?php //echo $form->field($model, 'dest_codunidadeenvio')->textInput() ?>

    <?php //echo $form->field($model, 'dest_codtipo')->textInput(['maxlength' => 10]) ?>

    <?php //echo $form->field($model, 'dest_codsituacao')->textInput(['maxlength' => 10]) ?>
    <?php //echo $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>

    <?php
echo FileInput::widget([
    'model' => $model,
    'attribute' => 'file[]',
    'options' => ['multiple' => true,
    'showUpload' => true,
    ]
]);
    ?>
<br>

<!-- Render create form -->    
   <?= $this->render('/despachos/_form', [
        'despachos' => $despachos,
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
