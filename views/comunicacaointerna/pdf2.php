<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\DespachocomunicacaoDeco;
use app\models\Unidades;
use app\models\Despachos;
use app\models\Cargos_car;
use app\models\Colaborador;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

//RESGATANDO AS INFORMAÇÕES DA CI
$dest_coddestino = $model->dest_coddestino;
$unidade_solicitante = $model->comunicacaointerna->unidades->uni_nomeabreviado;
$dest_nomeunidadedest =  $model->dest_nomeunidadedest;
$dest_codcomunicacao = $model->dest_codcomunicacao;
$com_codcomunicacao = $model->comunicacaointerna->com_codcomunicacao;
$com_codsituacao = $model->comunicacaointerna->situacao->sitco_situacao1;
$datasolicitacao = $model->comunicacaointerna->com_datasolicitacao;
$com_titulo = $model->comunicacaointerna->com_titulo;
$com_texto = $model->comunicacaointerna->com_texto;
$com_codcolaboradorautorizacao = $model->comunicacaointerna->colaboradorAutorizacao->usuario->usu_nomeusuario;
$com_codcargoautorizacao = $model->comunicacaointerna->cargo->car_cargo;
$com_dataautorizacao = $model->comunicacaointerna->com_dataautorizacao;
$com_codtipo = $model->comunicacaointerna->com_codtipo;
$cod_situacao = $model->comunicacaointerna->com_codsituacao;
$com_usuarioEncerramento = $model->comunicacaointerna->com_usuarioEncerramento;
$com_dataEncerramento = $model->comunicacaointerna->com_dataEncerramento;

$session = Yii::$app->session;

//PEGANDO OS DESTINATÁIOS NESSE DESPACHO
     $sql = "SELECT * FROM destinocomunicacao_dest WHERE dest_codcomunicacao ='".$dest_codcomunicacao. "' AND dest_codtipo = 2";
     $model = Destinocomunicacao::findBySql($sql)->all(); 

     $sqlCopia = "SELECT * FROM destinocomunicacao_dest WHERE dest_codcomunicacao ='".$dest_codcomunicacao. "' AND dest_codtipo = 4 AND dest_coddespacho = 0";
     $modelCopia = Destinocomunicacao::findBySql($sqlCopia)->all(); 
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
th{ text-align: center;} .assinatura{font-size: 10px;} p{ margin: 0px 10px 10px;} .anexos {font-size: 12px;font-weight: bold;}
</style>
</head>

<body>

<?php
//MENSAGEM INFORMANDO O USUÁRIO E A DATA QUE FINALIZOU A CI
  if($cod_situacao == 5 AND $com_usuarioEncerramento != NULL ){

  echo "<div class='alert alert-danger' align='center' role='alert'><span class='glyphicon glyphicon-alert' aria-hidden='true'></span> Comunicação Interna <b>Encerrada</b> por: <b> ". $com_usuarioEncerramento ."</b> na data ". date('d/m/Y à\s H:i', strtotime($com_dataEncerramento)) ."</div>";
  }
?>

<table width="100%" border="1">
  <tr>
    <td width="10%" rowspan="2"><img src="../views/comunicacaointerna/pdf/logo.jpg" width="115" height="70" /></td> <!-- width="115" height="70" -->
    <td width="58%" height="43" style="background-color: #d9edf7;"><div align="center"><b> FORMULÁRIO DE DESPACHO</b></div></td>
    <td width="24%"><div align="center"><b>CÓDIGO: <?php echo $com_codcomunicacao ?></b></div></td>
  </tr>
  <tr>
    <td height="39">[<em><b>ASSUNTO</b></em>] <?php echo $com_titulo ?></td>
    <td><div align="center">SITUAÇÃO: <?php echo $com_codsituacao ?></div></td>
  </tr>
</table>
<br />
<table width="100%" border="1">
  <tr>
    <th height="28" scope="col">DATA/HORA</th>
    <th width="41%" scope="col">DE</th>
    <th scope="col">PARA MANIFESTAÇÃO</th>
  </tr>
  <tr>
    <td width="19%" height="44" scope="col"><div align="center"><?php echo date('d/m/Y H:i:s', strtotime($datasolicitacao)); ?></div></td>
    <td width="41%" scope="col"><div align="center"><?php echo $unidade_solicitante ?></div></td>
    <td width="40%" scope="col"><div>
      <?php foreach ($model as $models) { ?>
      &nbsp;<?php echo $models['dest_nomeunidadedest']; ?><br>
      <?php } ?>
      <br>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif">

      &nbsp;<em><b>Para Conhecimento:</b><br>
     <?php foreach ($modelCopia as $modelsCopia) { ?>
    <?php
      $sqlDataUnidadeCopia = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$dest_codcomunicacao."' AND deco_nomeunidade = '".$modelsCopia['dest_nomeunidadedestCopia']."'  AND deco_data >= '".$modelsCopia['dest_data']."' ";
      $dataUnidadeCopia = DespachocomunicacaoDeco::findBySql($sqlDataUnidadeCopia)->one();
    ?>
          &nbsp;<?php echo $modelsCopia['dest_nomeunidadedestCopia'].' - ' ?>
          <?php if($modelsCopia['dest_codsituacao'] == 3): ?> 
           <span class="badge badge-success" style="background-color:#27ae60; font-size:10px">Ciente</span>(<?= date('d/m/Y à\s H:i:s', strtotime($dataUnidadeCopia['deco_data'])); ?>) <br>
          <?php else: ?> 
            <span class="badge badge-success" style="background-color:#e74c3c; font-size:10px">Pendente</span><br>
        </em> 
      <?php endif; ?>
      <?php } ?><br>
      </font></div></td>
  <tr>
    <!-- <th height="122" scope="row">DISCRIMINAÇÃO</th> -->
    <td colspan="3"><p>&nbsp;</p><?php echo $com_texto ?>
    <p>&nbsp;</p>
    <p class="anexos">ANEXOS - - - - - - - - - - - - - - -  - - -<br />
      <?php
//GET ANEXOS
    if($files=\yii\helpers\FileHelper::findFiles('uploads/' . $com_codcomunicacao,['recursive'=>FALSE])){
    if (isset($files[0])) {
        foreach ($files as $index => $file) {
            $nameFicheiro = substr($file, strrpos($file, '/') + 6);
  if($com_codtipo == 2 && $session["sess_responsavelsetor"] != 1)
  {
    echo '***************** Arquivos Confidenciais';
  }else{
            echo Html::a($nameFicheiro, Url::base().'/uploads/'. $com_codcomunicacao. '/' . mb_convert_encoding($nameFicheiro, "UTF-8", "Windows-1252"), ['target'=>'_blank', 'data-pjax'=>"0"]) . "<br/>" ;
          }
      } 
    }
  }

?>
    </p>
        <div class="assinatura" align="right">Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $com_codcolaboradorautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $com_codcargoautorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo date('d/m/Y H:i:s', strtotime($com_dataautorizacao)); ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
</table>
<hr />
<table width="100%" border="1">
  <tr style="background-color: #d9edf7;">
    <th height="51" colspan="3" scope="col">DESPACHOS E ENCAMINHAMENTOS</th>
  </tr>
  <?php
  $sql6 = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$dest_codcomunicacao."' AND deco_codsituacao = 2 AND deco_despacho != 'Ciente.' order by deco_coddespacho desc";
  $modelDespacho = Despachos::findBySql($sql6)->all(); 
  foreach ($modelDespacho as $models) {
     
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
    $sql = "SELECT * FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$dest_codcomunicacao."' AND dest_codtipo = 3 AND dest_coddespacho = '".$deco_coddespacho."'";
    $unidade = Destinocomunicacao::findBySql($sql)->all(); 

    $sql2 = "SELECT * FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$dest_codcomunicacao."' AND dest_codtipo = 4 AND dest_coddespacho = '".$deco_coddespacho."'";
    $unidade2 = Destinocomunicacao::findBySql($sql2)->all();

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
    <th width="40%">PARA MANIFESTAÇÃO</th>
  </tr>
  <tr>
    <td scope="row"><div align="center"><?php echo date('d/m/Y H:i:s', strtotime($deco_data)); ?></div></td>
    <td><div align="center"><?php echo $unidade_despachante ?></div></td>
    <td><div>
      <?php foreach ($unidade as $unidades) { ?>
      &nbsp;<?php echo $unidades['dest_nomeunidadedest']; ?><br>
      <?php } ?>
      <br>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><b>&nbsp;Para Conhecimento:</b><br>
     <?php foreach ($unidade2 as $unidades2) { ?>
    <?php
      $sql3 = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$dest_codcomunicacao."' AND deco_nomeunidade = '".$unidades2['dest_nomeunidadedestCopia']."'  AND deco_data >= '".$unidades2['dest_data']."' ";
      $unidade3 = DespachocomunicacaoDeco::findBySql($sql3)->one();
    ?>
         &nbsp;<?php echo $unidades2['dest_nomeunidadedestCopia'].' - ' ?>
          <?php if($unidades2['dest_codsituacao'] == 3): ?> 
           <span class="badge badge-success" style="background-color:#27ae60; font-size:10px">Ciente</span>&nbsp;(<?= date('d/m/Y à\s H:i:s', strtotime($unidade3['deco_data'])); ?>) <br>
          <?php else: ?>
            <span class="badge badge-success" style="background-color:#e74c3c; font-size:10px">Pendente</span><br>
        </em> 
      <?php endif; ?>
      <?php } ?><br>
      </font></div></td>
  <tr>

    <td colspan="3"><p>&nbsp;</p><p><?php echo $deco_despacho ?></p>
    <p>&nbsp;</p>

    <p class="anexos"><i class="glyphicon glyphicon-file"></i> ANEXOS DESPACHO- - - - - - - - - - - - - - -<br />
      <?php
           $sql_destino = "SELECT DISTINCT dest_coddespacho FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 3";

      $destino = Destinocomunicacao::findBySql($sql_destino)->all(); 

      foreach ($destino as $destinos) {

        $dest_coddespacho = $destinos["dest_coddespacho"];

//GET ANEXOS
      if($deco_coddespacho == $dest_coddespacho){
    $files=\yii\helpers\FileHelper::findFiles('uploads/'. $com_codcomunicacao . '/' . $deco_coddespacho);
    if (isset($files[0])) {
        foreach ($files as $index => $file) {
            $nameFicheiro = substr($file, strrpos($file, '/') + 6);
            
  if($com_codtipo == 2 && $session["sess_responsavelsetor"] != 1)
  {
    echo '***************** Arquivos Confidenciais';
  }else{
            echo Html::a(utf8_encode($nameFicheiro), Url::base().'/uploads/'. $com_codcomunicacao. "/" . $deco_coddespacho . "/" . utf8_encode($nameFicheiro), ["target"=>"_blank", 'data-pjax'=>"0"]) . "<br/>";
          }
        }
       }
       }
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

  <p style="color:#00337d"><b>* Só imprima este despacho eletrônico em caso de necessidade. Salve em Formato PDF e armaze-o na Pasta do Setor disponível na Rede.  <p></b>

  <p style="color:#00337d"><b>** "A responsabilidade social e a preservação ambiental significa um compromisso com a vida."  <p></b>
  
</body>
</html>
