<?php

namespace app\controllers;

use Yii;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaSearch;
use app\models\Destinocomunicacao;
use app\models\Emailusuario;
use app\models\DestinocomunicacaoSearch;
use app\models\UploadForm;
use app\models\Unidades;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;

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
        
            //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $destinocomunicacao = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'destinocomunicacao' => $destinocomunicacao,
        ]);

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
                    //setando a session da comunicação
                    //$session->set('comunicacao', $model);

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

                //Resgatando as sessões da CI
                 //$session = Yii::$app->session;

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
                                $destinocomunicacao->dest_codtipo = 2; //TIPO = COM CÓPIA
                                $destinocomunicacao->dest_codsituacao = 1; // AGUARDANDO ABERTURA
                                $destinocomunicacao->dest_coddespacho = 0; // AGUARDANDO DESPACHO
                                $destinocomunicacao->dest_data = date('Y-m-d H:i:s');

        //USUÁRIOS APENAS IRÃO EDITAR COMUNICAÇÕES COM STATUS DE 'EM ELABORAÇÃO'
        if($model->com_codsituacao <> 1){

        Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Não é possível <strong>EDITAR</strong> a Comunicação Interna de código: ' . '<strong>' .$id. '</strong>' . ' pois a mesma está com status de  ' . '<strong>' . $model->situacao->sitco_situacao1 . '.</strong>');

        return $this->redirect(['index']);

                }else 
                if ($destinocomunicacao->load(Yii::$app->request->post()) && $destinocomunicacao->save())

                                    {   //REALIZA O LOOP DE 1 OU MAIS INSERÇÕES
                                        $destinocomunicacao = new Destinocomunicacao(); //reset model
                                        //Coletar id, nome e unidade da CI
                                        $destinocomunicacao->dest_codcomunicacao=$model->com_codcomunicacao;
                                        $destinocomunicacao->dest_codcolaborador=$model->com_codcolaborador;
                                        $destinocomunicacao->dest_codunidadeenvio=$model->com_codunidade;
                                        $destinocomunicacao->dest_nomeunidadeenvio=$session['sess_unidade'];
                                        $destinocomunicacao->dest_data = date('Y-m-d H:i:s');

$teste = Yii::$app->request->post('Destinocomunicacao');
$teste2 = $teste['dest_nomeunidadedest'];

$sql_unidades = "SELECT * FROM `db_base`.`unidade_uni` INNER JOIN `db_ci`.`destinocomunicacao_dest` ON `db_base`.`unidade_uni`.`uni_nomeabreviado` = `db_ci`.`destinocomunicacao_dest`.`dest_nomeunidadedest` WHERE `db_ci`.`destinocomunicacao_dest`.`dest_codcomunicacao` ='".$destinocomunicacao->dest_codcomunicacao."' AND `db_ci`.`destinocomunicacao_dest`.`dest_nomeunidadedest` ='".$teste2."'";

        $unidades = Unidades::findBySql($sql_unidades)->all(); 

        foreach ($unidades as $unidade) {

              $cod_unidade = $unidade['uni_codunidade'];

                $command = $connection->createCommand(
                 "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codunidadedest` = ".$cod_unidade." WHERE `dest_codcomunicacao` ='".$model->com_codcomunicacao."' AND `dest_nomeunidadedest` ='".$teste2."'");
                $command->execute();

             }
                                    }

                                    $searchModel = new DestinocomunicacaoSearch();
                                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
                                    
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
                                            'searchModel' => $searchModel,
                                            'dataProvider' => $dataProvider,
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
          $contador = 0;
          $manda_email = 0;
          $unidade_destino = "";
          $sql_unidade_destino = "SELECT dest_codunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = ".$model->com_codcomunicacao;

          $unidades = Destinocomunicacao::findBySql($sql_unidade_destino)->all();
                 foreach ($unidades as $unidade)
                    {
                     $unidade_destino  = $unidade["dest_codunidadedest"];
                   

          $sql_email_unidade = "SELECT `db_base`.`emailusuario_emus`.`emus_email` FROM `db_base`.`usuario_usu`, `db_base`.`emailusuario_emus`, `db_base`.`responsavelambiente_ream`, `db_base`.`colaborador_col` WHERE ream_codunidade = '".$unidade_destino."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = usu_codusuario and usu_codusuario = emus_codusuario";  
      
                          $email_unidades = Emailusuario::findBySql($sql_email_unidade)->all(); 
                          foreach ($email_unidades as $email_unidade)
                                       {
                                         $email_unidade_gerente  = $email_unidade["emus_email"];

                                                Yii::$app->mailer->compose()
                                                ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                                                ->setTo($email_unidade_gerente)
                                                ->setSubject('CI Aguardando Despacho')
                                                ->setTextBody('Existe uma CI de código: '.$id.' aguardando seu despacho')
                                                ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe uma Comunicação Interna de <strong style="color: #337ab7"">código: '.$id.'</strong> EM CIRCULAÇÃO aguardando seu DESPACHO. <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para realizar o DESPACHO. <br><br> Atenciosamente, <br> Sistema Gerenciador de Documentação Eletrônica.</h4>')
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
                                            'searchModel' => $searchModel,
                                            'dataProvider' => $dataProvider,
                                        ]);
                            }
     }
    /**
     * Deletes an existing Comunicacaointerna model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    
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

            $model = $this->findModel($id);

            $com_codcomunicacao = $model->com_codcomunicacao;
            $com_codsituacao = $model->situacao->sitco_situacao1;
            $datasolicitacao = $model->com_datasolicitacao;
            $com_titulo = $model->com_titulo;
            $com_texto = $model->com_texto;
            $com_codcolaboradorautorizacao = $model->colaborador->usuario->usu_nomeusuario;
            //$com_codcargoautorizacao = $model->cargo->car_cargo;
            $com_dataautorizacao = $model->com_dataautorizacao;
            $com_codtipo = $model->com_codtipo;

            //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $destinocomunicacao = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->all();



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

        return $pdf->render('imprimir', [
            'model' => $this->findModel($id),
            'destinocomunicacao' => $destinocomunicacao,
        ]);
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


