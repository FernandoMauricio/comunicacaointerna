<?php
/* @var $this yii\web\View */
namespace yii\bootstrap;
use yii\helpers\Html;

                session_start();

                   $nome_user    = $_SESSION['sess_nomeusuario'];
                   $unidade_user = $_SESSION['sess_unidade'];    

$this->title = 'Documentação Eletrônica';
?>

<div class="site-index">
    <div class="jumbotron">
        <h1> Documentação Eletrônica</h1>
    </div>
            <div class="body-content">
                <div class="container">
                    
                            <h3>Bem vindo, <?php echo $nome_user = ucwords(strtolower($nome_user))?>!</h3>
                            <div class="alert alert-danger" role="alert"><strong><?php echo $nome_user = ucwords(strtolower($nome_user)) . ",</strong>"?> você tem 3 despachos pendentes. Para visualizar, <a href="/teste/web/index.php?r=despachocomunicacao%2Findex" class="alert-link">clique aqui.</a></div>
                            <!--<div class="alert alert-success" role="alert">Existem 5 novas portarias cadastradas. Para visualizar, <a href="#" class="alert-link">clique aqui.</a></div>-->
                            <div class="panel panel-primary">

                <div class="panel-heading">
                            <i class="glyphicon glyphicon-book"></i>  Informações:
                </div>
                  <div class="panel-body">
                            <h4>CI - Comunicação Interna</h4>
                                <h5>Formalização de solicitações internas da empresa através de comunicações internas.</h5><br />
                            <h4>Portarias</h4>
                                <h5>Catálogo e cadastro das portarias que regem e regulamentam.</h5><br />
                            <h4>Sair (Logout)</h4>
                                <h5>Para sair do sistema.</h5> 
                     </div>
                </div>
            </div>
        </div>   
</div>
