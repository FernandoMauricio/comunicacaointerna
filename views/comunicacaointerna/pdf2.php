<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\Despachos;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

//RESGATANDO AS INFORMAÇÕES DA CI
$dest_nomeunidadeenvio =  $model->dest_nomeunidadeenvio;
$dest_nomeunidadedest =  $model->dest_nomeunidadedest;
$dest_codcomunicacao = $model->dest_codcomunicacao;
$com_codcomunicacao = $model->comunicacaointerna->com_codcomunicacao;
$com_codsituacao = $model->comunicacaointerna->situacao->sitco_situacao1;
$datasolicitacao = $model->comunicacaointerna->com_datasolicitacao;
$com_titulo = $model->comunicacaointerna->com_titulo;
$com_texto = $model->comunicacaointerna->com_texto;
$com_codcolaboradorautorizacao = $model->comunicacaointerna->colaborador->usuario->usu_nomeusuario;
$com_codcargoautorizacao = $model->comunicacaointerna->cargo->car_cargo;
$com_dataautorizacao = $model->comunicacaointerna->com_dataautorizacao;

$session = Yii::$app->session;
$codigo_comunicacao = $session['sess_comunicacao'];

//RESGATANDO AS INFORMAÇÕES DO DESPACHO
// $deco_coddespacho = $despachos->deco_coddespacho;
// $deco_data = $despachos->deco_data;
// $deco_despacho = $despachos->deco_despacho;
// $unidade_despachante = $despachos->deco_nomeunidade;
// $deco_nomeusuario = $despachos->deco_nomeusuario;

// //encaminhando as unidades
// $nome_unidade_encaminhar = "";
// $checa_espaco = 0;

// foreach ($deco_nomeunidade as $key=>$nome_unidade_encaminhar) {
//    if($checa_espaco == 0)
//     $nome_unidade_encaminhar = $dest_nomeunidadedest;
//        $checa_espaco ++;
// }

// $despachos->deco_codcolaborador
// $despachos->deco_codunidade 
// $despachos->deco_codcargo
// $despachos->deco_codsituacao

//PEGANDO OS DESTINATÁIOS NESSE DESPACHO
     $destinatarios = "";
     $contador = 0;
     $sql = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao ='".$dest_codcomunicacao. "' AND dest_codtipo = 2";

      $model = Destinocomunicacao::findBySql($sql)->all(); 

      foreach ($model as $models) {
         if($contador == 0){
              $destinatarios = $models['dest_nomeunidadedest']; 
       }else
            $destinatarios = $destinatarios."<br>".$models['dest_nomeunidadedest'];
          
       $contador ++; 
     }  




  //      if($com_codsituacao != 4 && $com_codsituacao != 5) 
  //   {
  //    $com_codcolaboradorautorizacao = "______________________________";
  //    $com_codcargoautorizacao = "";
  //    $com_dataautorizacao = "_____/_____/_____ às _____:_____:_____";
  // }

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
th{ text-align: center;} .assinatura{font-size: 10px;} p{ margin: 0px 10px 10px;}
</style>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td width="18%" rowspan="2"><img src="../views/comunicacaointerna/pdf/logo.jpg" width="115" height="70" /></td>
    <td width="58%" height="43"><div align="center"><strong> FORMULÁRIO DE DESPACHO</strong></div></td>
    <td width="24%"><div align="center"><strong>CÓDIGO: <?php echo $com_codcomunicacao ?></strong></div></td>
  </tr>
  <tr>
    <td height="39">[<em><strong>ASSUNTO</strong></em>] <?php echo $com_titulo ?></td>
    <td><div align="center">SITUAÇÃO: <?php echo $com_codsituacao ?></div></td>
  </tr>
</table>
<br />
<table width="100%" border="1">
  <tr>
    <th height="28" scope="col">DATA</th>
    <th width="41%" scope="col">SOLICITANTE</th>
    <th scope="col">DESTINATÁRIO</th>
  </tr>
  <tr>
    <td width="19%" height="44" scope="col"><div align="center"><?php echo $datasolicitacao ?></div></td>
    <td width="41%" scope="col"><div align="center"><?php echo $dest_nomeunidadeenvio ?></div></td>
    <td width="40%" scope="col"><div align="center"><?php echo $destinatarios ?></div></td>
  </tr>
  <tr>
    <th height="122" scope="row">DISCRIMINAÇÃO</th>
    <td colspan="2"><?php echo $com_texto ?>
        <div class="assinatura" align="right">Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $com_codcolaboradorautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $com_codcargoautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $com_dataautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
</table>
<hr />
<table width="100%" border="1">
  <tr>
    <th height="51" colspan="3" scope="col">DESPACHOS E ENCAMINHAMENTOS</th>
  </tr>
  <?php
  $sql6 = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$codigo_comunicacao."' AND deco_codsituacao = 2 order by deco_coddespacho";
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
     $sql = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$codigo_comunicacao."' AND dest_codsituacao = 3 AND dest_coddespacho = '".$deco_coddespacho."'";

      $model = Destinocomunicacao::findBySql($sql)->all(); 

      foreach ($model as $models) {
         if($checa_espaco == 0)
              $nome_unidade_encaminhar = $models['dest_nomeunidadedest']; 
       else
            $nome_unidade_encaminhar = $nome_unidade_encaminhar."<br>".$models['dest_nomeunidadedest'];
          
       $checa_espaco ++; 
     }  
     ?>
  <tr>
    <th width="19%" scope="row">DATA</th>
    <th width="41%">REMETENTE</th>
    <th width="40%">DESTINATÁRIO</th>
  </tr>
  <tr>
    <td scope="row"><div align="center"><?php echo $deco_data ?></div></td>
    <td><div align="center"><?php echo $unidade_despachante ?></div></td>
    <td><p align="center"><?php echo $nome_unidade_encaminhar ?></p>
  </tr>
  <tr>
    <th height="305" scope="row">DESPACHO</th>
    <td colspan="2"><?php echo $deco_despacho ?>
        <div class="assinatura" align="right">Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $nome_despachante ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $deco_cargo ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $deco_data ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
</html>