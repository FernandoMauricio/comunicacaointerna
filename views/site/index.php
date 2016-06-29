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
                        <i class="glyphicon glyphicon-star-empty"></i>O que há de novo? - Versão 1.4 - Publicado em 30/06/2016
            </div>
              <div class="panel-body">
              <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Destinos com cópia</strong></h5>
                            <h5>- Incluído um novo campo de destino chamado de "Com cópia para" onde poderão ser inclusos unidades/setores que apenas irão inserir a ciência na CI e <strong style="color: red;">NÃO poderão realizar o DESPACHO</strong>.</h5>
                            <h5>- Comunicações internas que tiverem sido realizados algum tipo de despacho aparecerão por primeiro na listagem de despachos pendentes.</h5><br>

              <h4><strong style="color: #337ab7;">Ações Corretivas</strong></h4>
                       <h5><i class="glyphicon glyphicon-tag"></i><strong> Autorização de CI </strong></h5>
                            <h5>- Corrigido o problema na visualização de anexos de Comunicações Internas pendentes de aprovação onde não estava sendo possível visualizá-las.</h5><br>

              <h4><strong style="color: #337ab7;">Ações Preventivas</strong></h4>
                       <h5><i class="glyphicon glyphicon-tag"></i><strong> Autorização de CI </strong></h5>
                            <h5>- Alterado a caixa de autorização/reprovação de CI para dois novos botões "Aprovar" ou "Reprovar". Melhorando assim, a usabilidade do sistema.</h5>
                            <h5>- Foi incluido uma ação de exclusão de destinos da CI quando a mesma for reprovada pelo gerente, resolvendo assim o problema de duplicidade em alguns casos.</h5>
                            <h5>- Incluído a notificação por e-mail para os destinos da CI quando a mesma for feita por um colaborador e autorizada pelo gerente.</h5><br>
                        <h4 style="color: #d35400;"><i>Para visualizar detalhes de Versões Anteriores, clique abaixo:</i></h4>
                        <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                 </div>
            </div>
        </div>
    </div>   
</div>
