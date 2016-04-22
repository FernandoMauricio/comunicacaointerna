<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\SituacaodestinoSide;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoSearch;
use app\models\Comunicacaointerna;
use app\models\Unidades;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use nirvana\showloading\ShowLoadingAsset;




/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-form">

<?php
  ShowLoadingAsset::register($this);
  $this->registerJs(

   '$("document").ready(function(){
        $("#novo_destino").on("pjax:start", function() { $("#novo_destino").showLoading();});
        $("#novo_destino").on("pjax:end", function() {$.pjax.reload({container:"#destinocomunicacaoGrid", timeout: 3000});  //Reload GridView
        $("#novo_destino").hideLoading();
        });
    });
  '
);

?>
 <br>
    <?php yii\widgets\Pjax::begin(['id' => 'novo_destino']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?php
                    $rows = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($destinocomunicacao, 'dest_nomeunidadedest')->widget(Select2::classname(), [
                        'data' => array_merge(["" => ""], $data_unidades),
                        'options' => ['placeholder' => 'Selecione uma Unidade...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);                    
    ?> 

    <div class="form-group">
        <?= Html::submitButton('Inserir Unidade', ['class' =>  'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>


</div>

<?php
// $script = <<< JS

// $('form#{$destinocomunicacao->formName()}').on('beforeSubmit', function(e)
// {
//     var \$form = $(this);
//     $.post(
//         \$form.attr("action"), //serialize Yii2 form
//         \$form.serialize()
//           )
//         .done(function(result){
//              if(result == 1)
//              {
//                  $(\$form).trigger("reset");
//                  $.pjax.reload({container:'#destinocomunicacaoGrid', timeout: 3000});
//              }else
//              {
//                  $("#message").html(result);
//              }
//             }).fail(function()
//             {
//                 console.log("server error");
//             });
//     return false;
// });

// JS;
// $this->registerJS($script);
?>