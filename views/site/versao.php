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
        <h1 class="text-center"> Histórico de Versões</h1>
            <div class="body-content">
                <div class="container">
                    
                <div class="panel panel-primary">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-star-empty"></i> Versão 1.3 - (ATUALMENTE) - Publicado em 04/05/2016
                </div>
                  <div class="panel-body">
                            <h4><strong>Destinos / Encaminhamentos</strong></h4>
                                <h5>Um novo método para inserção de destinos/encaminhamentos foi inserido e está mais prático e simples que o anterior. Agora é necessário apenas escolher as unidades e realizar o despacho. <strong style="color: red;">NÃO será mais necesário</strong> clicar em "Incluir Unidade" e esperar o sistema incluir o destino selecionado. </h5><br />

                            <h4><strong>Botão "Finalizar CI"</strong></h4>
                                <h5>Esta ação na tela de "Despachos Pendentes" ficou obsoleta. Agora somente o autor da CI poderá realizar o ENCERRAMENTO da mesma na tela de "Criadas pelo Setor". </h5><br />

                            <h4><strong>Botão "Ciente"</strong></h4>
                                <h5>Um novo botão foi inserido na tela de "Depachos Pendentes". O mesmo será responsável pelo Despacho Automático, ou seja, caso o usuário queira despachar somente inserindo "Ciente" em seu despacho, esse botão fará isso. </h5><br />

                            <h4><strong>Alterações na barra de MENU</strong></h4>
                                <h5>As ações "SAIR" e "Alterar Senha" foram mescladas e incluídas em "USUARIO (Nome de usuário)".</h5><br />

                            <h4><strong>Avisos de Pendências de Despachos / Autorizações na Página Principal</strong></h4>
                                <h5>Agora o usuário somente irá ser sinalizado nesta tela caso haja alguma pendência.</h5><br />

                            <h4><strong>Layout do pedido de confirmação</strong></h4>
                                <h5>Alterado o layout do pedido de confirmação quando for realizar a finalização da CI ou realizar o Despacho Automático</h5><br />

                            <h4><strong>Layout da página principal</strong></h4>
                                <h5>Diminuição do tamanho do título "Documentação Eletrônica" e Inclusão do quadro de avisos de atualizações.</h5><br />
                     </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.2 - Publicado em 25/04/2016
                </div>
                  <div class="panel-body">
                            <h4><strong>Alterar Senha</strong></h4>
                                <h5>Incluído a funcionalidade para o usuário alterar a senha do Portal Senac</h5><br />
                            <h4><strong>Registro de Finalização de CI</strong></h4>
                                <h5>Os usuários receberão um e-mail informando o responsável que realizou o ENCERRAMENTO da CI. O registro poderá ser visualizado também em "Recebidas pelo Setor" ou "Criadas pelo Setor"</h5><br />
                            <h4><strong>Alterações no layout de e-mail</strong></h4>
                                <h5>As notificações que são enviadas por e-mail tiveram seu layout alterado para uma melhor visualização e compreensão por parte do usuário</h5><br />
                     </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.1 - Publicado em 08/04/2015
                </div>
                  <div class="panel-body">
                            <h4><strong>Melhoramento nas buscas de CI</strong></h4>
                                <h5>Melhorado o sistema de buscas em "Despachos/Autorizações" e "Recebidas pelo Setor", sendo incluído buscas por: TIPO, DATA DA SOLICITAÇÃO, TÍTULO.</h5><br />
                            <h4><strong>Inclusão de envio de e-mails</strong></h4>
                                <h5>Caso haja algum despacho pendente e/ou autorização pendente, o usuário será notificado por e-mail</h5><br />    
                     </div>
                </div>


            </div>
        </div>   
</div>
