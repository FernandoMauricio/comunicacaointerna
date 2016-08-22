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
            $sql = "SELECT * FROM `destinocomunicacao_dest` LEFT JOIN `comunicacaointerna_com` ON `destinocomunicacao_dest`.`dest_codcomunicacao` = `comunicacaointerna_com`.`com_codcomunicacao` WHERE (((`comunicacaointerna_com`.`com_codsituacao`=4) AND (`dest_codunidadedest`='".$cod_unidade."')) AND (`dest_codtipo` IN (2, 3,4))) AND (`dest_codsituacao`=2)";
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
                    
                            <h3>Bem vindo(a), <?php echo $nome_user = ucwords(strtolower($nome_user))?>!</h3>

                            <?php

                            if($_SESSION['sess_responsavelsetor'] == 1 AND $checar_ci > 0){

                            ?>
                            <div class="alert alert-danger" role="alert"><strong><?php echo $nome_user = ucwords(strtolower($nome_user)) . ",</strong>"?> você tem <?php echo $checar_ci ?> despacho(os) pendente(es). Para visualizar, <a href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=destinocomunicacao-circ%2Findex" class="alert-link">clique aqui.</a></div>
                            
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
                        <i class="glyphicon glyphicon-star-empty"></i>O que há de novo? - Versão 1.5 - Publicado em 22/08/2016
            </div>

                <div class="panel-body">
              <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Área Gerencial / Listagem de Despachos</strong></h5>
                            <h5>- Inclusão do botão <span class="label label-warning">Notificar</span> na área de despacho. Ao acionar esse botão, será enviado um e-mail a toda equipe do setor informando sobre a atualização na CI.</h5>
                            <h5>- Alteração na ordem de despachos/encaminhamentos. Os últimos despachos aparecerão por primeiro assim como já ocorre na listagem das Comunicações Internas.</h5>
                            <h5>- Cada Despacho mostrará as ciências dos destinatários que estão pendentes.</h5>
                            <h5>- Inclusão do campo TAG para ser utilizado por palavras-chave inseridas na criação da CI para uma melhor busca por determinados assuntos na Comunicação Interna.</h5><br>
                            <h4 style="color: #d35400;"><i>Para visualizar detalhes de Versões Anteriores, clique abaixo:</i></h4>
                            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                </div>
            </div>
        </div>
    </div>   
</div>
