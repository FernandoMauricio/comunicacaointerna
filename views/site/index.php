<?php
/* @var $this yii\web\View */
// namespace yii\bootstrap;
use yii\helpers\Html;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use yii\helpers\ArrayHelper;

                   $nome_user    = $_SESSION['sess_nomeusuario'];
                   $cod_unidade  = $_SESSION['sess_codunidade'];    

$this->title = 'Documentação Eletrônica';

            //BUSCA NO BANCO SE EXISTE CI PENDENTE DE DESPACHO
            $sql = "SELECT * FROM `destinocomunicacao_dest` LEFT JOIN `comunicacaointerna_com` ON `destinocomunicacao_dest`.`dest_codcomunicacao` = `comunicacaointerna_com`.`com_codcomunicacao` WHERE `comunicacaointerna_com`.`com_codsituacao`=4 AND `dest_codunidadedest`='".$cod_unidade."' AND `dest_codtipo` IN (2,3,4) AND `dest_codsituacao`=2 GROUP BY `dest_codcomunicacao`";
            $checar_ci = Destinocomunicacao::findBySql($sql)->count(); 

            //BUSCA NO BANCO SE EXISTE CI PENDENTE DE AUTORIZAÇÃO
             $checar_autorizacao = Comunicacaointerna::find()
                ->where(['com_codsituacao' => 3,'com_codunidade' => $cod_unidade])
                ->count(); 

?>

<div class="site-index">
        <h1 class="text-center"> Documentação Eletrônica</h1>
            <div class="body-content">
                <div class="container">
                    
                            <h3>Bem vindo(a), <?php echo $nome_user = utf8_encode(ucwords(strtolower($nome_user)))?>!</h3>

                            <?php

                            if($_SESSION['sess_responsavelsetor'] == 1 AND $checar_ci > 0){

                            ?>
                            <div class="alert alert-danger" role="alert"><b><?php echo $nome_user = utf8_encode(ucwords(strtolower($nome_user))) . ",</b>"?> você tem <?php echo $checar_ci ?> despacho(os) pendente(es). Para visualizar, <a href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=destinocomunicacao-circ%2Findex" class="alert-link">clique aqui.</a></div>
                            
                            <?php
                                 }       
                            ?>

                            <?php

                            if($_SESSION['sess_responsavelsetor'] == 1 AND $checar_autorizacao > 0){

                            ?>
                            <div class="alert alert-success" role="alert">Existem <?php echo $checar_autorizacao ?> Comunicação(ões) Interna(as) pendente(es) de autorização. Para visualizar, <a href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=comunicacaointerna-aut%2Findex" class="alert-link">clique aqui.</a></div>
                            
                            <?php
                                 }       
                            ?>

            <div class="panel panel-primary">
            <div class="panel-heading">
                        <i class="glyphicon glyphicon-star-empty"></i>O que há de novo? - Versão 1.6 - Publicado em 24/04/2018
            </div>
                <div class="panel-body">
                <h4><b style="color: #337ab7;">Implementações</b></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><b> Área Gerencial / Listagem de Despachos</b></h5>
                            <h5>- Alteração de nomenclatura do botão "Ciente" -> "Dar Ciência" na listagem de despachos pendentes.</h5>
                            <h5>- Alteração de nomenclatura do campo "PARA" -> "PARA MANIFESTAÇÃO" na CI.</h5>
                            <h5>- Alteração de nomenclatura do campo "Com cópia para" -> "Para Conhecimento" na CI.</h5>
                            <h5>- No histórico da CI, apenas aparecerão despachos de unidades que estão como destino "Para Manifestação". Respostas automáticas acionados pelo botão "Dar Ciência" não aparecerão mais.</h5>
                            <h5>- Inclusão da informação "Pendente" e "Ciente" com data e hora que foi realizado a ciência ao lado de cada unidade que está como destino "Para Conhecimento".</h5>
                            <h5>- Alteração no layout na área de despacho.</h5>
                            <h5>- Retirado a área "Listagem de Unidades/Setores que ainda não despacharam".</h5>
                            <h5>- Retirado a Inserção automática de destinos já inseridos na CI. Agora, apenas o remetente estará de forma automática no destino. Caso queira incluir mais unidades, deverá fazê-lo manualmente.</h5><br />
                <h4><b style="color: #337ab7;">Correções</b></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><b> Área Gerencial / Listagem de Despachos</b></h5>
                            <h5>- Corrigido o erro que não estava sendo possível realizar o download de anexos diretamente na listagem de Despachos Pendentes.</h5><br />

                            <h4 style="color: #d35400;"><i>Para visualizar detalhes de Versões Anteriores, clique abaixo:</i></h4>
                            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                </div>
            </div>
        </div>
    </div>   
</div>
