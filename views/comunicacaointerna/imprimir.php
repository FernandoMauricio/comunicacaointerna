<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaAut;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\SituacaocomunicacaoSitco;
use app\models\Despachos;
use app\models\Cargos;
use app\models\Unidades;
use app\models\Colaborador;
use app\models\UsuarioUsu;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

$session = Yii::$app->session;

//RESGATANDO AS INFORMAÇÕES DA CI
// $com_codcomunicacao = $model->com_codcomunicacao;
// $com_codsituacao = $model->situacao->sitco_situacao1;
// $datasolicitacao = $model->com_datasolicitacao;
// $com_titulo = $model->com_titulo;
// $com_texto = $model->com_texto;
// $com_codcolaboradorautorizacao = $model->colaborador->usuario->usu_nomeusuario;
// //$com_codcargoautorizacao = $model->cargo->car_cargo;
// $com_dataautorizacao = $model->com_dataautorizacao;
// $com_codtipo = $model->com_codtipo;
$id = $_GET['id'];
//$datasolicitacao = $id['com_datasolicitacao'];

$sql_comunicacao = "SELECT * FROM comunicacaointerna_com WHERE com_codcomunicacao = ".$id."";
  $comunicacoes = Comunicacaointerna::findBySql($sql_comunicacao)->all(); 
  foreach ($comunicacoes as $comunicacao) {
     
     $com_codcomunicacao = $comunicacao["com_codcomunicacao"];
     $datasolicitacao = $comunicacao["com_datasolicitacao"];
     $com_texto = $comunicacao["com_texto"];
     $com_codsituacao = $comunicacao["com_codsituacao"];
     $com_titulo = $comunicacao["com_titulo"];
     $com_codtipo = $comunicacao["com_codtipo"];
     $codcolaborador_autorizacao = $comunicacao["com_codcolaboradorautorizacao"];
     $codcargo_autorizacao = $comunicacao["com_codcargoautorizacao"];
     $com_dataautorizacao = $comunicacao["com_dataautorizacao"];
     $com_codunidade = $comunicacao["com_codunidade"];
   }


   //UNIDADE SOLICITANTE
   $sql_solicitante = "SELECT `db_base`.`unidade_uni`.`uni_nomeabreviado` FROM `db_base`.`unidade_uni` WHERE `uni_codunidade` = '".$com_codunidade."'";
          $solicitantes = Unidades::findBySql($sql_solicitante)->all();
                 foreach ($solicitantes as $solicitante)
                    {
                     $unidade_solicitante  = $solicitante["uni_nomeabreviado"];
                    }


    // COLABORADOR AUTORIZOU....
   $sql_colaborador = "SELECT `db_base`.`usuario_usu`.`usu_nomeusuario` FROM `db_base`.`usuario_usu`, `db_base`.`colaborador_col` WHERE col_codcolaborador = '".$codcolaborador_autorizacao."' and col_codusuario = usu_codusuario";
          $colaboradores = UsuarioUsu::findBySql($sql_colaborador)->all();
                 foreach ($colaboradores as $colaborador)
                    {
                     $nome_autorizacao  = $colaborador["usu_nomeusuario"];
                    }
                         
    // CARGO AUTORIZOU....
   $sql_cargo = "SELECT `db_base`.`cargos_car`.`car_cargo` FROM  `db_base`.`cargos_car` WHERE car_codcargo = '".$codcargo_autorizacao."'";
          $cargos = Cargos::findBySql($sql_cargo)->all();
                 foreach ($cargos as $cargo)
                    {
                     $cargo_autorizacao  = $cargo["car_cargo"];
                    }
          

//SITUACAO_CI...
$sql_situacao = "SELECT sitco_situacao1 FROM situacaocomunicacao_sitco WHERE sitco_codsituacao = '".$com_codsituacao."'";
$situacao = SituacaocomunicacaoSitco::findBySql($sql_situacao)->all();
foreach ($situacao as $nome_situacao) { 
$situacao_comunicacao  = $nome_situacao["sitco_situacao1"];
}


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

//PEGANDO OS DESTINATÁIOS COMO CÓPIA NESSE DESPACHO
     $destinatariosCopia = "";
     $contador = 0;
     $sqlCopia = "SELECT dest_nomeunidadedestCopia FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 4 AND dest_codsituacao = 2 OR dest_codcomunicacao = '".$com_codcomunicacao."' AND dest_codtipo = 4 AND dest_codsituacao = 3";

      $modelCopia = Destinocomunicacao::findBySql($sqlCopia)->all(); 

      foreach ($modelCopia as $modelsCopia) {
         if($contador == 0){
              $destinatariosCopia = $modelsCopia['dest_nomeunidadedestCopia']; 
       }else
            $destinatariosCopia = $destinatariosCopia."<br>".$modelsCopia['dest_nomeunidadedestCopia'];
          
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
</head>
<body>
<table width="100%" border="1">
  <tr>
    <td width="18%" rowspan="2"><img src="../views/comunicacaointerna/pdf/logo.jpg" width="115" height="70" /></td>
    <td width="58%" height="43"><div align="center" style="font-size: 12px; "><strong> FORMULÁRIO DE DESPACHO</strong></div></td>
    <td width="24%"><div align="center"  style="font-size: 12px;"><strong>CÓDIGO: <?php echo $com_codcomunicacao ?></strong></div></td>
  </tr>
  <tr>
    <td height="39"  style="font-size: 12px;">[<em><strong>ASSUNTO</strong></em>] <?php echo $com_titulo ?></td>
    <td><div align="center"  style="font-size: 12px;">SITUAÇÃO: <?php echo $situacao_comunicacao ?></div></td>
  </tr>
</table>

<table width="100%" border="1">
  <tr>
    <th height="28" scope="col" style="font-size: 12px;">DATA/HORA</th>
    <th width="41%" scope="col"  style="font-size: 12px;">SOLICITANTE</th>
    <th scope="col"  style="font-size: 12px;">DESTINATÁRIO</th>
  </tr>
  <tr>
    <td width="19%" height="44" scope="col"><div align="center"  style="font-size: 12px;"><?php echo date('d/m/Y H:i:s', strtotime($datasolicitacao)); ?></div></td>
    <td width="41%" scope="col"><div align="center"  style="font-size: 12px;"><?php echo $unidade_solicitante ?></div></td>
    <td width="40%" scope="col"><div align="center"  style="font-size: 12px;"><?php echo $destinatarios ?></div><br>
     <?php if($contador != 0)
         {
       ?>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><strong>Cópia Para:</strong><br>
      <?php echo $destinatariosCopia ?></em> 
      <?php } ?>
      </font></div></td>
  </tr>
  </tr>
    <tr>
    <!-- <th height="122" scope="row">DISCRIMINAÇÃO</th> -->
    <td colspan="3" style="font-size: 12px;"><?php echo $com_texto ?>
    <p>&nbsp;</p>
      <div class="assinatura" style="font-size: 10px;" >Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $nome_autorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $cargo_autorizacao ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo date('d/m/Y H:i:s', strtotime($com_dataautorizacao)) ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
</table>
<hr />
<table width="100%" border="1">
  <tr>
    <th height="51" align="center" style="font-size: 12px;" colspan="3" scope="col">DESPACHOS E ENCAMINHAMENTOS</th>
  </tr>
  <?php
  $sql6 = "SELECT * FROM despachocomunicacao_deco WHERE deco_codcomunicacao = '".$id."' AND deco_codsituacao = 2 order by deco_coddespacho";
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
     $contador = 0;
     $sql_encaminhar = "SELECT dest_nomeunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$id."' AND dest_codtipo = 3 AND dest_coddespacho = '".$deco_coddespacho."'";

      $unidade = Destinocomunicacao::findBySql($sql_encaminhar)->all(); 

      foreach ($unidade as $unidades) {
         if($contador == 0)
              $nome_unidade_encaminhar = $unidades['dest_nomeunidadedest']; 
       else
            $nome_unidade_encaminhar = $nome_unidade_encaminhar."<br>".$unidades['dest_nomeunidadedest'];
          
       $contador ++; 
     }

     //PEGANDO OS DESTINATÁIOS ENCAMINHANDOS COMO CÓPIA NESSE DESPACHO
     $nome_unidade_encaminharCopia = "";
     $contador = 0;
     $sql_encaminharCopia = "SELECT dest_nomeunidadedestCopia FROM destinocomunicacao_dest WHERE dest_codcomunicacao = '".$id."' AND dest_codtipo = 4 AND dest_coddespacho = '".$deco_coddespacho."'";

      $unidadeCopia = Destinocomunicacao::findBySql($sql_encaminharCopia)->all(); 

      foreach ($unidadeCopia as $unidadesCopia) {
         if($contador == 0)
              $nome_unidade_encaminharCopia = $unidadesCopia['dest_nomeunidadedestCopia']; 
       else
            $nome_unidade_encaminharCopia = $nome_unidade_encaminharCopia."<br>".$unidadesCopia['dest_nomeunidadedestCopia'];
          
       $contador ++; 
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
    <th width="19%" scope="row"  style="font-size: 12px;">DATA/HORA</th>
    <th width="41%"  style="font-size: 12px;">REMETENTE</th>
    <th width="40%"  style="font-size: 12px;">DESTINATÁRIO</th>
  </tr>
  <tr>
    <td scope="row"><div align="center"  style="font-size: 12px;"><?php echo date('d/m/Y H:i:s', strtotime($deco_data)); ?></div></td>
    <td><div align="center"  style="font-size: 12px;"><?php echo $unidade_despachante ?></div></td>
    <td><div align="center"  style="font-size: 12px;"><?php echo $nome_unidade_encaminhar ?><br><br>
     <?php if($contador != 0)
         {
       ?>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><strong>Cópia Para:</strong><br>
      <?php echo $nome_unidade_encaminharCopia ?></em> 
      <?php } ?>
      </font></div></td>
  </tr>
  <tr>
    <!-- <th height="305" scope="row">DESPACHO</th> -->
    <td colspan="3"  style="font-size: 12px;"><?php echo $deco_despacho ?><br>
      <div class="assinatura" style="font-size: 10px;" >Assinado Eletronicamente Por:&nbsp;&nbsp;&nbsp;<br />
      <?php echo $nome_despachante ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo $deco_cargo ?>&nbsp;&nbsp;&nbsp;<br />
      <?php echo date('d/m/Y H:i:s', strtotime($deco_data)) ?>&nbsp;&nbsp;&nbsp;<br />
  </div></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
</html>
