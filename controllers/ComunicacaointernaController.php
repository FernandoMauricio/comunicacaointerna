<?php

namespace app\controllers;

use Yii;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaSearch;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoSearch;
use app\models\UploadForm;
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
        $model = new Comunicacaointerna();

                //Coletar a sessão do usuário
                $session = Yii::$app->session;
                $model->com_codcolaborador= $session['sess_codcolaborador'];
                $model->com_codunidade= $session['sess_codunidade'];
                $session->close();

                if ($_SESSION['sess_responsavelsetor'] == 0){

                $model->nomesituacao = 'Em Elaboração';
                $model->com_codsituacao = 1;
        
                }else{

                $model->nomesituacao = 'Em Elaboração';
                $model->com_codsituacao = 1;
       
                }        

                if ($model->load(Yii::$app->request->post()) && $model->save())
                {
                    $model->com_datasolicitacao = date('Y-m-d h:m:s');

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
          
                $model = $this->findModel($id);

                //Resgatando as sessões da CI
                 $session = Yii::$app->session;

                //conexão com os bancos
                 $connection = Yii::$app->db;
                 $connection = Yii::$app->db_base;

                //Coletar a sessão do usuário e da tabela anexo
                $model->com_codcolaborador = $session['sess_codcolaborador'];
                $model->com_codunidade = $session['sess_codunidade'];

                //Caso NÃO seja gerente, situação fica PARA AUTORIZAÇÃO, se não, fica EM CIRCULAÇÃO
                if ($_SESSION['sess_responsavelsetor'] == 0){

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
                                $destinocomunicacao->dest_data = date('Y-m-d h:m:s');

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
                                        $destinocomunicacao->dest_data = date('Y-m-d h:m:s');
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
                            if ($_SESSION['sess_responsavelsetor'] == 0){

                            $model->com_codsituacao = 3; 
                            $model->save();           
                        }else{

                            $model->com_codsituacao = 4;
                            $model->com_dataautorizacao = date('Y-m-d h:m:s');
                            $model->com_codcolaboradorautorizacao = $session['sess_codcolaborador'];
                            $model->com_codcargoautorizacao = $session['sess_codcargo'];
                            $model->save();

                //Atualiza a situação do destino para "ABERTO"(cód 2) para poder realizar a filtragem e enviar o e-mail"
                $connection = Yii::$app->db;
                $command = $connection->createCommand(
                 "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codsituacao` = '2' WHERE `dest_codcomunicacao` =".$model->com_codcomunicacao);
                $command->execute();  

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


        // Privacy statement output demo
        public function actionPdf() {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'content' => $this->renderPartial('pdf2'),
                'options' => [
                    'title' => 'Comunicação Interna - Senac AM',
                    'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
                ],
                'methods' => [
                    'SetHeader' => ['DOCUMENTAÇÃO ELETRÔNICA - SENAC AM||Gerado em: ' . date("d/m/Y - H:i:s")],
                    'SetFooter' => ['Gerência de Informática Corporativa - GIC||Página {PAGENO}'],
                ]
            ]);
            return $pdf->render();
        }
}