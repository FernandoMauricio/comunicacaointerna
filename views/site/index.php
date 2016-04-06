<?php
/* @var $this yii\web\View */
// namespace yii\bootstrap;
use yii\helpers\Html;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use yii\helpers\ArrayHelper;

                   $nome_user    = $_SESSION['sess_nomeusuario'];
                   $unidade_user = $_SESSION['sess_unidade'];
                   $cod_unidade  = $_SESSION['sess_codunidade'];    


foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}



$this->title = 'Documentação Eletrônica';

            //BUSCA NO BANCO SE EXISTE CI PENDENTE DE DESPACHO
            $sql = "SELECT COUNT(*) FROM `destinocomunicacao_dest` LEFT JOIN `comunicacaointerna_com` ON `destinocomunicacao_dest`.`dest_codcomunicacao` = `comunicacaointerna_com`.`com_codcomunicacao` WHERE (((`comunicacaointerna_com`.`com_codsituacao`=4) AND (`dest_nomeunidadedest`='$unidade_user')) AND (`dest_codtipo` IN (2, 3))) AND (`dest_codsituacao`=2)";
            $checar_ci = Destinocomunicacao::findBySql($sql)->count(); 

             // $checar_ci = Destinocomunicacao::find()
             //    ->where(['dest_codsituacao' => 2, 'dest_coddespacho' => 0, 'dest_nomeunidadedest' => $_SESSION['sess_unidade']])
             //    ->count(); 

            //BUSCA NO BANCO SE EXISTE CI PENDENTE DE AUTORIZAÇÃO
             $checar_autorizacao = Comunicacaointerna::find()
                ->where(['com_codsituacao' => 3,'com_codunidade' => $cod_unidade])
                ->count(); 

?>

<div class="site-index">
    <div class="jumbotron">
        <h1> Documentação Eletrônica</h1>
        <p><a class="btn btn-lg btn-success" href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=comunicacaointerna%2Fcreate">Criar Comunicacação Interna</a></p>
    </div>
            <div class="body-content">
                <div class="container">
                    
                            <h3>Bem vindo(a), <?php echo $nome_user = ucwords(strtolower($nome_user))?>!</h3>

                            <?php

                            if($_SESSION['sess_responsavelsetor'] == 1){

                            ?>
                            <div class="alert alert-danger" role="alert"><strong><?php echo $nome_user = ucwords(strtolower($nome_user)) . ",</strong>"?> você tem <?php echo $checar_ci ?> despacho(os) pendente(es). Para visualizar, <a href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=destinocomunicacao-circ%2Findex" class="alert-link">clique aqui.</a></div>
                            <div class="alert alert-success" role="alert">Existem <?php echo $checar_autorizacao ?> Comunicação(ões) Interna(as) pendente(es) de autorização. Para visualizar, <a href="http://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=comunicacaointerna-aut%2Findex" class="alert-link">clique aqui.</a></div>
                            
                            <?php
                                 }       
                            ?>
                <div class="panel panel-primary">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-book"></i>  Informações:
                </div>
                  <div class="panel-body">
                            <h4>Criadas pelo Setor</h4>
                                <h5>Comunicações Internas criadas pelo setor.</h5><br />
                            <h4>Recebidas pelo Setor</h4>
                                <h5>Comunicacções Internas recebidas pelo setor.</h5><br />
                            <h4>Despachos/Autorizações</h4>
                                <h5>Área Gerencial para despachos e autorizações de CI.</h5> 
                     </div>
                </div>
            </div>
        </div>   
</div>
