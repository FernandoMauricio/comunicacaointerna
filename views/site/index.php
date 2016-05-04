<?php
/* @var $this yii\web\View */
// namespace yii\bootstrap;
use yii\helpers\Html;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use yii\helpers\ArrayHelper;

                   $nome_user    = $_SESSION['sess_nomeusuario'];
                   $unidade_user = $_SESSION['sess_codunidade'];
                   $cod_unidade  = $_SESSION['sess_codunidade'];    

$this->title = 'Documentação Eletrônica';

            //BUSCA NO BANCO SE EXISTE CI PENDENTE DE DESPACHO
            $sql = "SELECT COUNT(*) FROM `destinocomunicacao_dest` LEFT JOIN `comunicacaointerna_com` ON `destinocomunicacao_dest`.`dest_codcomunicacao` = `comunicacaointerna_com`.`com_codcomunicacao` WHERE (((`comunicacaointerna_com`.`com_codsituacao`=4) AND (`dest_codunidadedest`='$unidade_user')) AND (`dest_codtipo` IN (2, 3))) AND (`dest_codsituacao`=2)";
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
                            <i class="glyphicon glyphicon-star-empty"></i>  O que há de novo? (Versão 1.3)
                </div>
                  <div class="panel-body">
                            <h4><strong>Destinos / Encaminhamentos</strong></h4>
                                <h5>Um novo método para inserção de destinos/encaminhamentos foi inserido e está mais prático e simples que o anterior. Agora é necessário apenas escolher as unidades e realizar o despacho. <strong style="color: red;">NÃO será mais necesário</strong> clicar em "Incluir Unidade" e esperar o sistema incluir o destino selecionado. </h5><br />

                            <h4><strong>Alterações na barra de MENU</strong></h4>
                                <h5>As ações "SAIR" e "Alterar Senha" foram mescladas e incluídas em "USUARIO (Nome de usuário)".</h5><br />

                            <h4><strong>Avisos de Pendências de Despachos / Autorizações na Página Principal</strong></h4>
                                <h5>Agora o usuário somente irá ser sinalizado nesta tela caso haja alguma pendência.</h5><br />

                            <h4><strong>Layout da página principal</strong></h4>
                                <h5>Diminuição do tamanho do título "Documentação Eletrônica" e Inclusão do quadro de avisos de atualizações</h5><br />
   
                            <h4 style="color: #d35400;"><i>Para visualizar detalhes de Versões Anteriores, clique abaixo:</i></h4>
                            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                     </div>
                </div>
            </div>
        </div>   
</div>
