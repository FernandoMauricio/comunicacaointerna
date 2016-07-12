<?php

namespace app\controllers;

use Yii;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaSearch;
use app\models\Destinocomunicacao;
use app\models\Emailusuario;
use app\models\DestinocomunicacaoSearch;
use app\models\DestinocomunicacaoPendenteEnvioSearch;
use app\models\UploadForm;
use app\models\Unidades;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

use mPDF;


/**
 * ComunicacaointernaController implements the CRUD actions for Comunicacaointerna model.
 */
class ComunicacaointernaController extends Controller
{
  
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comunicacaointerna models.
     * @return mixed
     */
    public function actionIndex()

    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }

        $searchModel = new ComunicacaointernaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Comunicacaointerna model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }
        
        $model = $this->findModel($id);

            //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $destinocomunicacao = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->all();

                //Verifica se a unidade tem acesso a CI criada
      if($session['sess_codunidade'] == $model->com_codunidade){

        return $this->render('view', [
            'model' => $this->findModel($id),
            'destinocomunicacao' => $destinocomunicacao,
        ]);

      }else{

        throw new NotFoundHttpException('Você não tem acesso a essa Comunicação Interna.');

      }

    }

    /**
     * Creates a new Comunicacaointerna model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }

        $model = new Comunicacaointerna();

                //Coletar a sessão do usuário
                //$session = Yii::$app->session;
                $model->com_codcolaborador= $session['sess_codcolaborador'];
                $model->com_codunidade= $session['sess_codunidade'];

                if ($session['sess_responsavelsetor'] == 0){

                $model->nomesituacao = 'Em Elaboração';
                $model->com_codsituacao = 1;
        
                }else{

                $model->nomesituacao = 'Em Elaboração';
                $model->com_codsituacao = 1;
       
                }        

                if ($model->load(Yii::$app->request->post()) && $model->save())
                {
                    $model->com_datasolicitacao = date('Y-m-d H:i:s');

                    $model->save();

            return $this->redirect(['update', 'id' => $model->com_codcomunicacao]);
            
            }else{
            return $this->render('create', [
                        'model' => $model,
                        ]);
                }
            }

    /**
     * Updates an existing Comunicacaointerna model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
      {
         $session = Yii::$app->session;
         
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }
          
                $model = $this->findModel($id);

                //conexão com os bancos
                 $connection = Yii::$app->db;
                 $connection = Yii::$app->db_base;

                //Coletar a sessão do usuário e da tabela anexo
                $model->com_codcolaborador = $session['sess_codcolaborador'];
                $model->com_codunidade = $session['sess_codunidade'];

                //Caso NÃO seja gerente, situação fica PARA AUTORIZAÇÃO, se não, fica EM CIRCULAÇÃO
                if ($session['sess_responsavelsetor'] == 0){

                $model->nomesituacao = 'Enviar para Autorização';
            }else{

                $model->nomesituacao = 'Enviar para Circulação';
            }                     
                                //INSERIR DESTINOS NA COMUNICACAO INTERNA              
                                 $destinocomunicacao = new Destinocomunicacao();
                                //Coletar id, nome e unidade da CI
                                $destinocomunicacao->dest_codcomunicacao=$model->com_codcomunicacao;
                                $destinocomunicacao->dest_codcolaborador=$model->com_codcolaborador;
                                $destinocomunicacao->dest_codunidadeenvio=$model->com_codunidade;
                                $destinocomunicacao->dest_nomeunidadeenvio=$session['sess_unidade'];
                                $destinocomunicacao->dest_codtipo = 2; //TIPO = DIRETAMENTE PARA
                                $destinocomunicacao->dest_codsituacao = 1; // AGUARDANDO ABERTURA
                                $destinocomunicacao->dest_coddespacho = 0; // AGUARDANDO DESPACHO
                                $destinocomunicacao->dest_data = date('Y-m-d H:i:s');

        //USUÁRIOS APENAS IRÃO EDITAR COMUNICAÇÕES COM STATUS DE 'EM ELABORAÇÃO'
        if($model->com_codsituacao <> 1){

        Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Não é possível <strong>EDITAR</strong> a Comunicação Interna de código: ' . '<strong>' .$id. '</strong>' . ' pois a mesma está com status de  ' . '<strong>' . $model->situacao->sitco_situacao1 . '.</strong>');

        return $this->redirect(['index']);

                }else 
                if ($destinocomunicacao->load(Yii::$app->request->post())  &&  $model->save()) {   

        //-------------------DESTINOS QUE PODERÃO REALIZAR DESPACHOS
        //pega os destinos que foram escolhidos
        $request = Yii::$app->request;
        $Destinocomunicacao = Yii::$app->request->post('Destinocomunicacao');

        //realiza a filtragem com o formato de array
        $listagemUnidades = "SELECT * FROM `unidade_uni` WHERE `uni_nomeabreviado` IN('".implode("','",$Destinocomunicacao['dest_nomeunidadedest'])."')";

                 $destinos = Unidades::findBySql($listagemUnidades)->all(); 

                foreach ($destinos as $destino) {

                    $cod_unidade = $destino['uni_codunidade'];
                    $nomeUnidade = $destino['uni_nomeabreviado'];

        //seleciona somente as unidades escolhidas pelo usuário
        $sql_unidades = "SELECT * FROM `db_base`.`unidade_uni` INNER JOIN `db_ci`.`destinocomunicacao_dest` ON `db_base`.`unidade_uni`.`uni_codunidade` = `db_ci`.`destinocomunicacao_dest`.`dest_codunidadedest` WHERE `db_ci`.`destinocomunicacao_dest`.`dest_codcomunicacao` ='".$destinocomunicacao->dest_codcomunicacao."' AND `db_ci`.`destinocomunicacao_dest`.`dest_nomeunidadedest` ='".$nomeUnidade."'";

                    //insert no banco das unidades da qual o usuário selecionou
                        $command = $connection->createCommand();
                        $command->insert('db_ci.destinocomunicacao_dest', array('dest_codcomunicacao'=>$destinocomunicacao->dest_codcomunicacao, 'dest_codcolaborador'=>$destinocomunicacao->dest_codcolaborador, 'dest_codunidadeenvio'=>$destinocomunicacao->dest_codunidadeenvio, 'dest_codunidadedest'=>$cod_unidade, 'dest_data'=>date('Y-m-d H:i:s'), 'dest_codtipo'=>2, 'dest_codsituacao'=>1, 'dest_coddespacho'=>0, 'dest_nomeunidadeenvio'=>$session['sess_unidade'],'dest_nomeunidadedest'=>$nomeUnidade ));
                        $command->execute();

                }

        //------------------DESTINOS QUE APENAS PODERÃO DÁ CIÊNCIA NA CI
if($Destinocomunicacao['dest_nomeunidadedestCopia'] > 0) {
        //pega os destinos que foram escolhidos
        $request = Yii::$app->request;
        $Destinocomunicacao = Yii::$app->request->post('Destinocomunicacao');

        //realiza a filtragem com o formato de array
        $listagemUnidades = "SELECT * FROM `unidade_uni` WHERE `uni_nomeabreviado` IN('".implode("','",$Destinocomunicacao['dest_nomeunidadedestCopia'])."')";

                 $destinos = Unidades::findBySql($listagemUnidades)->all(); 

                foreach ($destinos as $destino) {

                    $cod_unidade = $destino['uni_codunidade'];
                    $nomeUnidade = $destino['uni_nomeabreviado'];

        //seleciona somente as unidades escolhidas pelo usuário
        $sql_unidades = "SELECT * FROM `db_base`.`unidade_uni` INNER JOIN `db_ci`.`destinocomunicacao_dest` ON `db_base`.`unidade_uni`.`uni_codunidade` = `db_ci`.`destinocomunicacao_dest`.`dest_codunidadedest` WHERE `db_ci`.`destinocomunicacao_dest`.`dest_codcomunicacao` ='".$destinocomunicacao->dest_codcomunicacao."' AND `db_ci`.`destinocomunicacao_dest`.`dest_nomeunidadedestCopia` ='".$nomeUnidade."'";

                    //insert no banco das unidades da qual o usuário selecionou
                        $command = $connection->createCommand();
                        $command->insert('db_ci.destinocomunicacao_dest', array('dest_codcomunicacao'=>$destinocomunicacao->dest_codcomunicacao, 'dest_codcolaborador'=>$destinocomunicacao->dest_codcolaborador, 'dest_codunidadeenvio'=>$destinocomunicacao->dest_codunidadeenvio, 'dest_codunidadedest'=>$cod_unidade, 'dest_data'=>date('Y-m-d H:i:s'), 'dest_codtipo'=>4, 'dest_codsituacao'=>1, 'dest_coddespacho'=>0, 'dest_nomeunidadeenvio'=>$session['sess_unidade'],'dest_nomeunidadedestCopia'=>$nomeUnidade ));
                        $command->execute();
                }
              }
          }
                                    
            //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $checar_destino = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->count();               

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                            Yii::$app->session->setFlash('success', 'Comunicacação Interna de código: <strong>'.$id. ' </strong>criada com sucesso!');

                            //VAI SER VERIFICADO SE EXISTE DESTINO PARA A CI
                            if($checar_destino == 0 ){

                                            Yii::$app->getSession()->setFlash('warning', [
                                           'type' => 'warning',
                                           'duration' => 5000,
                                           'icon' => 'glyphicon glyphicon-info-sign',
                                           'message' => 'É preciso primeiramente especificar o(s) destino(s) desta Comunicação Interna!',
                                           'title' => 'Aviso!',
                                           'positonY' => 'top',
                                           'positonX' => 'right'
                                       ]);
                                            return $this->render('update', [
                                            'model' => $model,
                                            'destinocomunicacao' => $destinocomunicacao,
                                        ]);

                            }

                                    //GRAVAR ANEXOS///////
                                if (!empty($_POST)) {

                                $model->file = UploadedFile::getInstances($model, 'file');

                                $subdiretorio = "uploads/" . $model->com_codcomunicacao;

                                        if(!file_exists($subdiretorio))
                                                {
                                                  if(!mkdir($subdiretorio));
                                                }
                                                        if ($model->file && $model->validate()) {
                                                            foreach ($model->file as $file)
                                                                 {
                                                                     $file->saveAs($subdiretorio.'/'. $file->baseName . '.' . $file->extension);

                                                                    $model->com_anexo = $subdiretorio.'/';
                                                                    $model->save();
                                                                 }
                                                }
                                        }                
                //Caso NÃO seja gerente, situação fica PARA AUTORIZAÇÃO, se não, fica EM CIRCULAÇÃO
                            if ($session['sess_responsavelsetor'] == 0){

                            $model->com_codsituacao = 3; 
                            $model->save();

         //ENVIANDO EMAIL PARA O GERENTE INFORMANDO SOBRE A CI PENDENTE DE AUTORIZAÇÃO
          $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->com_codunidade."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
      
      $email_autorizacao = Emailusuario::findBySql($sql_email)->all(); 
      foreach ($email_autorizacao as $email)
          {
            $email_gerente  = $email["emus_email"];

                            Yii::$app->mailer->compose()
                            ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                            ->setTo($email_gerente)
                            ->setSubject('CI Aguardando Autorização')
                            ->setTextBody('Existe uma CI de código: '.$id.' aguardando sua autorização')
                            ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe uma Comunicação Interna de <strong style="color: #337ab7"">código: '.$id.'</strong> aguardando sua autorização. <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para AUTORIZAR a CI. <br><br> Atenciosamente, <br> Sistema Gerenciador de Documentação Eletrônica.</h4>')
                            ->send();
                        }        
                        }else{

                            $model->com_codsituacao = 4;
                            $model->com_dataautorizacao = date('Y-m-d H:i:s');
                            $model->com_codcolaboradorautorizacao = $session['sess_codcolaborador'];
                            $model->com_codcargoautorizacao = $session['sess_codcargo'];
                            $model->save();

                //Atualiza a situação do destino para "ABERTO"(cód 2) para poder realizar a filtragem e enviar o e-mail"
                $connection = Yii::$app->db;
                $command = $connection->createCommand(
                 "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codsituacao` = '2' WHERE `dest_codcomunicacao` =".$model->com_codcomunicacao);
                $command->execute();

         //ENVIA EMAIL PARA TODAS AS UNIDADES QUE FORAM INSERIDAS NO DESTINO DA CI
         //CRIANDO ARRAY COM SETORES PARTICIPANTES DA CI....
         //
         //
          $manda_email = 0;
          $unidade_destino = "";
          $sql_unidade_destino = "SELECT dest_codunidadedest,dest_nomeunidadedest,dest_nomeunidadedestCopia FROM destinocomunicacao_dest WHERE dest_codcomunicacao = ".$model->com_codcomunicacao;

          $unidades = Destinocomunicacao::findBySql($sql_unidade_destino)->all();
                 foreach ($unidades as $unidade)
                    {
                     $unidade_destino  = $unidade["dest_codunidadedest"];
                     $nomeunidade_destino  = $unidade["dest_nomeunidadedest"];
                     $nomeunidade_destinoCopia  = $unidade["dest_nomeunidadedestCopia"];
                   

          $sql_email_unidade = "SELECT `db_base`.`emailusuario_emus`.`emus_email` FROM `db_base`.`usuario_usu`, `db_base`.`emailusuario_emus`, `db_base`.`responsavelambiente_ream`, `db_base`.`colaborador_col` WHERE ream_codunidade = '".$unidade_destino."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = usu_codusuario and usu_codusuario = emus_codusuario";  
      
                          $email_unidades = Emailusuario::findBySql($sql_email_unidade)->all(); 
                          foreach ($email_unidades as $email_unidade)
                                       {
                                         $email_unidade_gerente  = $email_unidade["emus_email"];

                                                Yii::$app->mailer->compose()
                                                ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                                                ->setTo($email_unidade_gerente)
                                                ->setSubject('CI '.$id. ' Aguardando Despacho - ' .$nomeunidade_destino .$nomeunidade_destinoCopia)
                                                ->setTextBody('Existe uma CI de código: '.$id.' aguardando seu despacho')
                                                ->setHtmlBody('<p>Prezado(a)&nbsp;Gerente,</p>

                                                <p>Existe uma Comunica&ccedil;&atilde;o Interna <span style="color:#337AB7">'.$id.' </span>aguardando seu despacho. Abaixo, segue algumas informa&ccedil;&otilde;es; :</p>

                                                <p><strong>T&iacute;tulo: </strong><span style="color:#337AB7">'. $model->com_titulo .'</span></p>

                                                <p><strong>Autorizado Por: </strong><span style="color:#337AB7">'. $model->colaborador->usuario->usu_nomeusuario .'</span></p>

                                                <p><strong>Data/Hora</strong>:&nbsp;<span style="color:#337AB7">'. date('d/m/Y H:i', strtotime($model->com_dataautorizacao)) .'</span></p>

                                                ')
                                                ->send();

                                       }
                $manda_email++;
            }


                        }
                             return $this->redirect(['index']);

                                    }else {
                                        return $this->render('update', [
                                            'model' => $model,
                                            'destinocomunicacao' => $destinocomunicacao,
                                        ]);
                            }
     }
    /**
     * Deletes an existing Comunicacaointerna model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
  

      public function actionEncerrar($id)
    {
         $session = Yii::$app->session;
         
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }


        //USUÁRIOS APENAS IRÃO EDITAR COMUNICAÇÕES COM STATUS DE 'EM ELABORAÇÃO'
       if ($session['sess_responsavelsetor'] == 0){

        Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Somente o <strong>GERENTE</strong> poderá finalizar a Comunicação Interna');

        return $this->redirect(['index']);

                }else 

    $model = $this->findModel($id);
    $model->com_usuarioEncerramento = $session['sess_nomeusuario'];
    $model->com_dataEncerramento = date('Y-m-d H:i:s');

    //encerra a comunicacao que está em Circulação
    $connection = Yii::$app->db;
    $command = $connection->createCommand(
    "UPDATE `db_ci`.`comunicacaointerna_com` SET `com_codsituacao` = '5', `com_usuarioEncerramento` = '".$model->com_usuarioEncerramento."', `com_dataEncerramento` = '".$model->com_dataEncerramento."'  WHERE `com_codcomunicacao` = ".$model->com_codcomunicacao."");
    $command->execute();

         //ENVIO DE E-MAIL PARA OS GERENTES RETIRANDO A DUPLICIDADE DO ENVIO INFORMANDO SOBRE O ENCERRAMENTO
          $sql_unidade_destino = "SELECT DISTINCT dest_nomeunidadedest,dest_codcomunicacao,dest_codunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = ".$model->com_codcomunicacao;

                 $unidades = Destinocomunicacao::findBySql($sql_unidade_destino)->all();
                 foreach ($unidades as $unidade)
                    {
                     $id_ci  = $unidade["dest_codcomunicacao"];
                     $unidade_destino  = $unidade["dest_codunidadedest"];
                     $nomeunidade_destino  = $unidade["dest_nomeunidadedest"];
                     $id_usuarioEncerramento = $unidade["dest_codcolaborador"];


                $sql_email_unidade = "SELECT DISTINCT `db_base`.`emailusuario_emus`.`emus_email` FROM `db_base`.`usuario_usu`, `db_base`.`emailusuario_emus`, `db_base`.`responsavelambiente_ream`, `db_base`.`colaborador_col` WHERE ream_codunidade = '".$unidade_destino."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = usu_codusuario and usu_codusuario = emus_codusuario";  
      
                          $email_unidades = Emailusuario::findBySql($sql_email_unidade)->all();
                          foreach ($email_unidades as $email_unidade)
                                       {
                                         $email_unidade_gerente  = $email_unidade["emus_email"];

                                                Yii::$app->mailer->compose()
                                                ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                                                ->setTo($email_unidade_gerente)
                                                ->setSubject('CI '.$id_ci. ' ENCERRADA - ' .$nomeunidade_destino)
                                                ->setTextBody('A Comunicação Interna de código: '.$id_ci.' foi ENCERRADA!')
                                                ->setHtmlBody('<p>Prezado(a), Gerente</p>

                                                <p>A Comunica&ccedil;&atilde;o Interna de c&oacute;digo <span style="color:#337AB7"><strong>'.$id_ci.'</strong></span> foi ENCERRADA:</p>

                                                <p><strong>Respons&aacute;vel pelo Encerramento</strong>:<span style="color:#337AB7"><strong> '.$model->com_usuarioEncerramento.'</strong></span></p>

                                                <p><strong>Data do Encerramento</strong>: <span style="color:#337AB7"><strong> '.date('d/m/Y H:i', strtotime($model->com_dataEncerramento)).'</strong></span></p>

                                                <p><i><strong>Por favor, n&atilde;o responda esse e-mail. Acesse http://portalsenac.am.senac.br</strong></i></p>

                                                <p>Atenciosamente,&nbsp;</p>

                                                <p>Sistema Gerenciador de Documentação Eletrônica</p>')
                                                ->send();
            
                      }

           }

    Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Comunicação Interna de código: ' . '<strong>' .$model->com_codcomunicacao. '</strong> foi <strong>ENCERRADA!</strong>');
     
return $this->redirect(['index']);

}

  public function actionDelete($id)
    {   
                //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $checar_destino = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->count();

                if ($model = Comunicacaointerna::findOne($id)){
                            if($checar_destino > 0){

                            Yii::$app->session->setFlash('danger', '<strong>ERRO! </strong> Não é possível <strong>EXCLUIR</strong> a Comunicação Interna de código: ' . '<strong>' .$id. '</strong>' . '. Existem destinos inseridos na mesma!');
                            return $this->redirect(['index']);
                        }else{
                            $model->delete();
                            //Exclusão da CI
                          Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Comunicação Interna de código: ' . '<strong>' .$id. '</strong>' . ' excluída!');
                    return $this->redirect(['index']);  
                        }
                    }
                        //Exclusão dos destinos da CI
                 if($model = Destinocomunicacao::findOne($id)){
                     
                      if($model->delete()) {

                          Yii::$app->getSession()->setFlash('danger', [
                               'type' => 'danger',
                               'duration' => 5000,
                               'icon' => 'glyphicon glyphicon-info-sign',
                               'message' => 'Destino excluido com sucesso!',
                               'title' => 'Exclusão',
                               'positonY' => 'top',
                               'positonX' => 'right'
                           ]);
                             return $this->redirect(['update', 'id' => $model->dest_codcomunicacao]);       
                        }                          
                }
    }


            // Privacy statement output demo
        public function actionImprimir($id) {
          
            $session = Yii::$app->session;
            $model = $this->findModel($id);

            //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
            $destinocomunicacao = Destinocomunicacao::find()->where(['dest_codcomunicacao' => $_GET])->all();

            $unidades = Destinocomunicacao::find()->select('dest_codcomunicacao')->where(['dest_codcomunicacao' => $_GET, 'dest_codunidadedest' => $session['sess_codunidade']])->all();
                           foreach ($unidades as $unidade)
                              {
                               $dest_codcomunicacao  = $unidade["dest_codcomunicacao"];
                              }

            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'content' => $this->renderPartial('imprimir'),
                'options' => [
                    'title' => 'Comunicação Interna - Senac AM',
                    'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
                ],
                'methods' => [
                    'SetHeader' => ['DOCUMENTAÇÃO ELETRÔNICA - SENAC AM||Gerado em: ' . date("d/m/Y - H:i:s")],
                    'SetFooter' => ['Gerência de Informática Corporativa - GIC||Página {PAGENO}'],
                ]
            ]);

            //Verifica se a unidade tem acesso a CI criada
            if(isset($dest_codcomunicacao)){

                    return $pdf->render('imprimir', [
                        'model' => $this->findModel($id),
                        'destinocomunicacao' => $destinocomunicacao,
                    ]);

                  }else{

                throw new NotFoundHttpException('Você não tem acesso a essa Comunicação Interna.');

                  }
        }


    /**
     * Finds the Comunicacaointerna model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comunicacaointerna the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comunicacaointerna::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
}


