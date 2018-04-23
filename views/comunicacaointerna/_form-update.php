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
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use yii\grid\GridView;
use yii\widgets\Pjax;

use faryshta\widgets\JqueryTagsInput;

$dest_codunidadeenvio =  $_SESSION['sess_codunidade'];
$dest_codcolaborador = $_SESSION['sess_codcolaborador'];

?>

<?php 

//Get all flash messages and loop through them
foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) :'',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) :'',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : '',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : '',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
 
<!-- Render create form -->    

<div class="comunicacao-interna-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>          

        <?php echo $form->errorSummary($model); ?>  
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?php
                    $rows = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($destinocomunicacao, 'dest_nomeunidadedest')->widget(Select2::classname(), [
                        'data' => $data_unidades,
                        'options' => ['placeholder' => 'Selecione as Unidades...', 'multiple'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-6">
                <?php  

                    $rowsUnidadesCopias = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rowsUnidadesCopias, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($destinocomunicacao, 'dest_nomeunidadedestCopia')->widget(Select2::classname(), [
                        'data' => $data_unidades,
                        'options' => ['placeholder' => 'Selecione as Unidades...', 'multiple'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php
                   $rowsTipos = TipodocumentacaoTipdo::find()->all();
                   $data = ArrayHelper::map($rowsTipos, 'tipdo_codtipo', 'tipdo_tipo');
                   echo $form->field($model, 'com_codtipo')->radiolist($data);
                ?> 
            </div>

        <div class="col-md-5"><?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100, 'placeholder' => 'Insira o Título...'])?></div>

        <div class="col-md-4">

        <?= $form->field($model, 'com_tag')->widget(JqueryTagsInput::classname(), [
             'clientOptions' => [
                 'defaultText' => '',
                 'width' => '100%',
                 'height' => '100%',
                 'interactive' => true,
             ],
         ]) ?>

        </div>
    </div>

        <?= $form->field($model, 'com_texto')->widget(CKEditor::className(), [
        'options' => ['rows' => 6, 'placeholder' => 'Insira seu Despacho...'],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'nomesituacao')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'com_codsituacao')->hiddenInput()->label(false) ?>

    <?php
echo '<label class="control-label">Anexos</label>  <strong style="color: #E61238""><small>extensões permitidas: .pdf / .zip / .rar / .doc / .docx</small></strong>';
echo FileInput::widget([
    'model' => $model,
    'language' => 'pt',
    'attribute' => 'file[]',
    'options' => ['multiple' => true, 'accept'=>'.pdf', '.zip', '.rar', '.doc', '.docx'],
    'pluginOptions' => [
    'language' => 'pt',
    'showRemove'=> false,
    'showUpload'=> false,
    ],
]);
    ?>
<p></p>

    <div class="form-group">
        
        <?= Html::submitButton('Enviar Comunicação Interna', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
