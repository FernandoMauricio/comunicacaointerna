<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaAut;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\Despachos;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

$session = Yii::$app->session;

//RESGATANDO AS INFORMAÇÕES DA CI
$com_codcomunicacao = $model->com_codcomunicacao;
$com_codsituacao = $model->situacao->sitco_situacao1;
$datasolicitacao = $model->com_datasolicitacao;
$com_titulo = $model->com_titulo;
$com_texto = $model->com_texto;
$com_codcolaboradorautorizacao = $model->colaborador->usuario->usu_nomeusuario;
//$com_codcargoautorizacao = $model->cargo->car_cargo;
$com_dataautorizacao = $model->com_dataautorizacao;
$com_codtipo = $model->com_codtipo;
$cod_situacao = $model->com_codsituacao;
$com_usuarioEncerramento = $model->com_usuarioEncerramento;
$com_dataEncerramento = $model->com_dataEncerramento;

// $com_usuarioEncerramento = $model->com_usuarioEncerramento;

//PEGANDO OS DESTINATÁIOS NESSE DESPACHO
     $destinatarios = "";
     $contador = 0;
     $sql2 = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 2 AND dest_codsituacao = 2 OR dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 2 AND dest_codsituacao = 3";

      $model = Destinocomunicacao::findBySql($sql2)->all(); 

      foreach ($model as $models) {
         if($contador == 0){
              $destinatarios = $models['dest_nomeunidadedest']; 
       }else
            $destinatarios = $destinatarios."<br>".$models['dest_nomeunidadedest'];
          
       $contador ++; 
     }  

?>


<?php

  if($com_codtipo == 2 && $session["sess_responsavelsetor"] != 1)
  {
       
     
     $com_titulo = "CONFIDENCIAL";
     $com_texto = "<div align='center'>********************************************************************************<br>".
              "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br></div>";

  }
  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
th{ text-align: center;} .assinatura{font-size: 10px;} p{ margin: 0px 10px 10px;}.anexos {font-size: 12px;font-weight: bold;}
</style>
</head>

<body>

 <?php

 //MENSAGEM INFORMANDO O USUÁRIO E A DATA QUE FINALIZOU A CI
  if($cod_situacao == 5 AND $com_usuarioEncerramento != NULL ){

    echo "<div class='alert alert-danger' align='center' role='alert'><span class='glyphicon glyphicon-alert' aria-hidden='true'></span> Comunicação Interna <strong>Encerrada</strong> por: <strong> ". $com_usuarioEncerramento ."</strong> na data ". date('d/m/Y à\s H:i', strtotime($com_dataEncerramento)) ."</div>";

  }

    ?>


<table width="100%" border="1">
  <tr>
    <td width="16%" rowspan="2"><img src="../views/comunicacaointerna/pdf/logo.jpg" width="180" height="75" /></td> <!-- width="115" height="70" -->
    <td width="58%" height="43"><div align="center"><strong> FORMULÁRIO DE DESPACHO</strong></div></td>
    <td width="24%"><div align="center"><strong>CÓDIGO: <?php echo $com_codcomunicacao ?></strong></div></td>
  </tr>
  <tr>
    <td height="39">[<em><strong>ASSUNTO</strong></em>] <?php echo $com_titulo ?></td>
    <td><div align="center">SITUAÇÃO: <?php echo $com_codsituacao ?><br></div></td>
  </tr>
</table>
<br />
<table width="100%" border="1">
  <tr>
    <th height="28" scope="col">DATA/HORA</th>
    <th width="41%" scope="col">DE</th>
    <th scope="col">PARA</th>
  </tr>
  <tr>
    <td width="19%" height="44" scope="col"><div align="center"><?php echo date('d/m/Y H:i:s', strtotime($datasolicitacao)); ?></div></td>
    <td width="41%" scope="col"><div align="center"><?php echo $session['sess_unidade'] ?></div></td>
    <td width="40%" scope="col"><div align="center"><?php echo $destinatarios ?></div></td>
  </tr>
    <tr>
  <!--   <th height="122" scope="row">DISCRIMINAÇÃO</th> -->
    
    <td colspan="3"><p>&nbsp;</p><?php echo $com_texto ?>
    <p>&nbsp;</p>
    <p class="anexos">ANEXOS - - - - - - - - - - - - - - -  - - -<br />
      <?php
      if($com_codsituacao != 'Em Elaboração'){
//GET ANEXOS
    $files=\yii\helpers\FileHelper::findFiles('uploads/'. $com_codcomunicacao,['recursive'=>FALSE]);
    if (isset($files[0])) {
        foreach ($files as $index => $file) {
            $nameFicheiro = substr($file, strrpos($file, '/') + 1);
            echo Html::a($nameFicheiro, Url::base().'/uploads/'. $com_codcomunicacao. '/' . $nameFicheiro, ['target'=>'_blank']). "<br/>"; // render do ficheiro no browser
        }
    } else {
        echo "Não existem arquivos disponíveis para download.";
    }
  }
?>
    </p>
        <!-- <div class="assinatura" align="right">Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br /> -->
      <?php //echo $com_codcolaboradorautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php //echo $com_codcargoautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php //echo $com_dataautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
</table>
<hr />
<table width="100%" border="1">
  <tr>
    <th height="51" colspan="3" scope="col">DESPACHOS E ENCAMINHAMENTOS</th>
  </tr>
  <?php
  $sql6 = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$com_codcomunicacao."' AND deco_codsituacao = 2 order by deco_coddespacho";
  $model = Despachos::findBySql($sql6)->all(); 
  foreach ($model as $models) {
     

     $unidade_despachante = "";
     $nome_despachante = "";
     $deco_coddespacho = $models["deco_coddespacho"];
     $deco_codcolaborador = $models["deco_codcolaborador"];
     $deco_codunidade = $models["deco_codunidade"];
     $deco_codcargo = $models["deco_codcargo"];
     $deco_data = $models["deco_data"];
     $deco_despacho = $models["deco_despacho"];
     $unidade_despachante = $models["deco_nomeunidade"];
     $nome_despachante = $models["deco_nomeusuario"];
     $deco_cargo = $models["deco_cargo"];


     //PEGANDO OS DESTINATÁIOS ENCAMINHANDOS NESSE DESPACHO
     $nome_unidade_encaminhar = "";
     $checa_espaco = 0;
     $sql = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 3 AND dest_coddespacho = '".$deco_coddespacho."'";

      $unidade = Destinocomunicacao::findBySql($sql)->all(); 

      foreach ($unidade as $unidades) {
         if($checa_espaco == 0)
              $nome_unidade_encaminhar = $unidades['dest_nomeunidadedest']; 
       else
            $nome_unidade_encaminhar = $nome_unidade_encaminhar."<br>".$unidades['dest_nomeunidadedest'];
          
       $checa_espaco ++; 
     }



  if($com_codtipo == 2 && $session["sess_responsavelsetor"] != 1)
  {
       

     $deco_despacho = "<div align='center'>********************************************************************************<br>".
              "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br>".
          "********************************************************************************<br></div>";
            
  }  
     ?>
  <tr>
    <th width="19%" scope="row">DATA/HORA</th>
    <th width="41%">DE</th>
    <th width="40%">PARA</th>
  </tr>
  <tr>
    <td scope="row"><div align="center"><?php echo date('d/m/Y H:i:s', strtotime($deco_data)); ?></div></td>
    <td><div align="center"><?php echo $unidade_despachante ?></div></td>
    <td><p align="center"><?php echo $nome_unidade_encaminhar ?></p>
  </tr>
  <tr>
    <!-- <th height="305" scope="row">DESPACHO</th> -->
    <td colspan="3"><p>&nbsp;</p><?php echo $deco_despacho ?>
    <p>&nbsp;</p>
    <p class="anexos">ANEXOS DESPACHO- - - - - - - - - - - - - - -<br />
      <?php
//GET ANEXOS
    $files=\yii\helpers\FileHelper::findFiles('uploads/'. $com_codcomunicacao . '/' . $deco_coddespacho);
    if (isset($files[0])) {
        foreach ($files as $index => $file) {
            $nameFicheiro = substr($file, strrpos($file, '/') + 1);
            echo Html::a($nameFicheiro, Url::base().'/uploads/'. $com_codcomunicacao. '/' . $nameFicheiro, ['target'=>'_blank']) . "<br/>" ; // render do ficheiro no browser
        }
    } else {
        echo "Não existem arquivos disponíveis para download.";
    }

    ?>
    </p>
      <div class="assinatura" align="right">Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $nome_despachante ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $deco_cargo ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo date('d/m/Y H:i:s', strtotime($deco_data)); ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
  <?php } ?>
</table>

<br>

  <p style="color:#00337d"><strong>* Só imprima este despacho eletrônico em caso de necessidade. Salve em Formato PDF e armaze-o na Pasta do Setor disponível na Rede.  <p></strong>

  <p style="color:#00337d"><strong>** "A responsabilidade social e a preservação ambiental significa um compromisso com a vida."  <p></strong>

<p>&nbsp;</p>
</body>
</html>
