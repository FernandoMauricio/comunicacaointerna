<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\models\Unidades;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php
                    $rows = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($encaminhamentos, 'dest_nomeunidadedest')->widget(Select2::classname(), [
                        'data' => $data_unidades,
                        'options' => ['placeholder' => 'Selecione uma Unidade...','multiple'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    ?> 

        <?php
                    $rows2 = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rows2, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($encaminhamentos, 'dest_nomeunidadedestCopia')->widget(Select2::classname(), [
                        'data' => $data_unidades,
                        'options' => ['placeholder' => 'Selecione uma Unidade...','multiple'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    ?> 

    <?php
echo '<label class="control-label">Anexos</label>  <strong style="color: #E61238""><small>extensões permitidas: .pdf / .zip / .rar / .doc / .docx</small></strong>';
echo FileInput::widget([
    'model' => $model,
    'language' => 'pt',
    'attribute' => 'file[]',
    'options' => ['multiple' => true, 'accept'=>'.pdf, .zip, .rar, .doc, .docx'],
    'pluginOptions' => [
    'language' => 'pt',
    'showRemove'=> false,
    'showUpload'=> false,
    ],
]);
    ?>
<br>

<!-- Render create form -->    
   <?= $this->render('/despachos/_form', [
        'despachos' => $despachos,
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
