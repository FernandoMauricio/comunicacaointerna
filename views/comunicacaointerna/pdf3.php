<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaAut;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\Despachos;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

//$session = Yii::$app->session;

//RESGATANDO AS INFORMAÇÕES DA CI
$com_codcomunicacao = $model->com_codcomunicacao;
$unidade_solicitante =  $model->unidades->uni_nomeabreviado;
$com_codsituacao = $model->situacao->sitco_situacao1;
$datasolicitacao = $model->com_datasolicitacao;
$com_titulo = $model->com_titulo;
$com_texto = $model->com_texto;
$com_codcolaboradorautorizacao = $model->colaborador->usuario->usu_nomeusuario;
$com_dataautorizacao = $model->com_dataautorizacao;
$com_anexo = $model->com_anexo;

//PEGANDO OS DESTINATÁIOS NESSE DESPACHO
     $destinatarios = "";
     $contador = 0;
     $sql = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 2 AND dest_codsituacao = 1";

      $model = Destinocomunicacao::findBySql($sql)->all(); 

      foreach ($model as $models) {
         if($contador == 0){
              $destinatarios = $models['dest_nomeunidadedest']; 
       }else
            $destinatarios = $destinatarios."<br>".$models['dest_nomeunidadedest'];
          
       $contador ++; 
     }  

     $contador = 0;
     $sql2 = "SELECT dest_nomeunidadedestCopia FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 4 AND dest_codsituacao = 1";

      $model2 = Destinocomunicacao::findBySql($sql2)->all(); 

      foreach ($model2 as $models2) {
         if($contador == 0){
              $destinatariosCopia = $models2['dest_nomeunidadedestCopia']; 
       }else
            $destinatariosCopia = $destinatariosCopia."<br>".$models2['dest_nomeunidadedestCopia'];
          
       $contador ++; 
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
<table width="100%" border="1">
  <tr>
    <td width="10%" rowspan="2"><img src="../views/comunicacaointerna/pdf/logo.jpg" width="115" height="70" /></td> <!-- width="115" height="70" -->
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
    <th height="28" scope="col">DATA/HORA</th>
    <th width="41%" scope="col">SOLICITANTE</th>
    <th scope="col">DESTINATÁRIO</th>
  </tr>
  <tr>
    <td width="19%" height="44" scope="col"><div align="center"><?php echo date('d/m/Y H:i:s', strtotime($datasolicitacao)) ?></div></td>
    <td width="41%" scope="col"><div align="center"><?php echo $unidade_solicitante ?></div></td>
    <td width="40%" scope="col"><div align="center"><?php echo $destinatarios ?><br><br>
     <?php if($contador != 0)
         {
       ?>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><strong>Cópia Para:</strong><br>
      <?php echo $destinatariosCopia; ?></em> 
      <?php } ?>
      </font></div></td>
  </tr>
    <tr>
    <th height="122" scope="row">DISCRIMINAÇÃO</th>
    <td colspan="2"><?php echo $com_texto ?>
    <p>&nbsp;</p>
    <p class="anexos">ANEXOS - - - - - - - - - - - - - - -  - - -<br />
      <?php
    //GET ANEXOS
        if($files=\yii\helpers\FileHelper::findFiles('uploads/' . $com_codcomunicacao,['recursive'=>FALSE])){
        if (isset($files[0])) {
            foreach ($files as $index => $file) {
                $nameFicheiro = substr($file, strrpos($file, '/') + 1);
                echo Html::a($nameFicheiro, Url::base().'/uploads/'. $com_codcomunicacao. '/' . mb_convert_encoding($nameFicheiro, "UTF-8"), ['target'=>'_blank']) . "<br/>" ;
          } 
        }
      }

    ?>
    </p>
</table>

<br>

  <p style="color:#00337d"><strong>* Só imprima este despacho eletrônico em caso de necessidade. Salve em Formato PDF e armaze-o na Pasta do Setor disponível na Rede.  <p></strong>

  <p style="color:#00337d"><strong>** "A responsabilidade social e a preservação ambiental significa um compromisso com a vida."  <p></strong>
  
<p>&nbsp;</p>
</body>
</html>
