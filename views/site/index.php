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
$sql = "SELECT * FROM `destinocomunicacao_dest` LEFT JOIN `comunicacaointerna_com` ON `destinocomunicacao_dest`.`dest_codcomunicacao` = `comunicacaointerna_com`.`com_codcomunicacao` WHERE `comunicacaointerna_com`.`com_codsituacao`=4 AND `dest_codunidadedest`='" . $cod_unidade . "' AND `dest_codtipo` IN (2,3,4) AND `dest_codsituacao`=2 GROUP BY `dest_codcomunicacao`";
$checar_ci = Destinocomunicacao::findBySql($sql)->count();

//BUSCA NO BANCO SE EXISTE CI PENDENTE DE AUTORIZAÇÃO
$checar_autorizacao = Comunicacaointerna::find()
    ->where(['com_codsituacao' => 3, 'com_codunidade' => $cod_unidade])
    ->count();

?>


<main role="main">
    <div class="jumbotron">
        <div class="col-sm-8 mx-auto">
        <h1 class="text-center">Documentação Eletrônica</h1>
            <p><?php if ($_SESSION['sess_responsavelsetor'] == 1 and $checar_ci > 0) : ?>
            <div class="alert alert-danger" role="alert"><b>
                    <?php echo $nome_user = ucwords(strtolower($nome_user)) . ",</b>"
                    ?> você tem <?php echo $checar_ci ?> despacho(os) pendente(es). Para visualizar, <a href="https://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=destinocomunicacao-circ%2Findex" class="alert-link">clique aqui.</a>
            </div>
        <?php endif; ?>
        <?php if ($_SESSION['sess_responsavelsetor'] == 1 and $checar_autorizacao > 0) : ?>
            <div class="alert alert-success" role="alert">Existem
                <?php echo $checar_autorizacao ?> Comunicação(ões) Interna(as) pendente(es) de autorização. Para visualizar, <a href="https://portalsenac.am.senac.br/comunicacaointerna/web/index.php?r=comunicacaointerna-aut%2Findex" class="alert-link">clique aqui.</a></div>
        <?php endif; ?></p>
        </div>
    </div>
</main>