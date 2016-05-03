<?php

namespace app\controllers;

use Yii;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use app\models\Unidades;
use app\models\DestinocomunicacaoEnc;
use app\models\DestinocomunicacaoEncSearch;
use app\models\DestinocomunicacaoSearch;
use app\models\DestinocomunicacaoCircSearch;
use app\models\DestinocomunicacaoPendenteCircSearch;
use app\models\Despachos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Emailusuario;

/**
 * DestinocomunicacaoCircController implements the CRUD actions for Destinocomunicacao model.
 */
class DestinocomunicacaoCircController extends Controller
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
     * Lists all Destinocomunicacao models.
     * @return mixed
     */
    public function actionIndex()
    {
                $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }

        $searchModel = new DestinocomunicacaoCircSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Destinocomunicacao model.
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Destinocomunicacao model.
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
        $model = new DestinocomunicacaoEnc();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dest_coddestino]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Destinocomunicacao model.
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

        //Resgatando o código da CI para sql no banco
        //$session = Yii::$app->session;
        $session->set('sess_comunicacao', $model->dest_codcomunicacao);
        $session->set('sess_destino', $model->dest_coddestino);
        $session->close();

            //BUSCA NO BANCO OS NOVOS DESTINOS (ENCAMINHAMENTOS)
            $searchEncModel = new DestinocomunicacaoEncSearch();
            $dataProvider2 = $searchEncModel->search(Yii::$app->request->queryParams); 

            //BUSCA NO BANCO OS DESTINOS QUE ESTÃO PENDENTES PARA DESPACHO
            $searchModel = new DestinocomunicacaoPendenteCircSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            //instancia novos encaminhamentos para o desapacho
            $encaminhamentos = new DestinocomunicacaoEnc();
            $encaminhamentos->dest_codcomunicacao = $model->comunicacaointerna->com_codcomunicacao;
            $encaminhamentos->dest_codcolaborador = $model->comunicacaointerna->com_codcolaborador;
            $encaminhamentos->dest_codunidadeenvio = $model->comunicacaointerna->com_codunidade;
            $encaminhamentos->dest_nomeunidadeenvio = $session['sess_unidade'];
            $encaminhamentos->dest_codtipo = 3; //TIPO = ENCAMINHADO PARA
            $encaminhamentos->dest_codsituacao = 1; // AGUARDANDO ABERTURA
            $encaminhamentos->dest_coddespacho = 0; // AGUARDANDO DESPACHO
            $encaminhamentos->dest_data = date('Y-m-d H:i:s');


         if ($encaminhamentos->load(Yii::$app->request->post()) && $model->save())
         {
            //REALIZA O LOOP DE 1 OU MAIS INSERÇÕES
            $encaminhamentos = new DestinocomunicacaoEnc();
            $encaminhamentos->dest_codcomunicacao = $model->comunicacaointerna->com_codcomunicacao;
            $encaminhamentos->dest_codcolaborador = $model->comunicacaointerna->com_codcolaborador;
            $encaminhamentos->dest_codunidadeenvio = $model->comunicacaointerna->com_codunidade;
            $encaminhamentos->dest_nomeunidadeenvio = $session['sess_unidade'];
            $encaminhamentos->dest_data = date('Y-m-d H:i:s');

        //pega os destinos que foram escolhidos
        $request = Yii::$app->request;
        $DestinocomunicacaoEnc = Yii::$app->request->post('DestinocomunicacaoEnc');

        //realiza a filtragem com o formato de array
        $listagemUnidades = "SELECT * FROM `unidade_uni` WHERE `uni_nomeabreviado` IN('".implode("','",$DestinocomunicacaoEnc['dest_nomeunidadedest'])."')";

                 $destinos = Unidades::findBySql($listagemUnidades)->all(); 

                foreach ($destinos as $destino) {

                    $cod_unidade = $destino['uni_codunidade'];
                    $nomeUnidade = $destino['uni_nomeabreviado'];

        //seleciona somente as unidades escolhidas pelo usuário
        $sql_unidades = "SELECT * FROM `db_base`.`unidade_uni` INNER JOIN `db_ci`.`destinocomunicacao_dest` ON `db_base`.`unidade_uni`.`uni_codunidade` = `db_ci`.`destinocomunicacao_dest`.`dest_codunidadedest` WHERE `db_ci`.`destinocomunicacao_dest`.`dest_codcomunicacao` ='".$encaminhamentos->dest_codcomunicacao."' AND `db_ci`.`destinocomunicacao_dest`.`dest_nomeunidadedest` ='".$nomeUnidade."'";


         //insert no banco das unidades da qual o usuário selecionou
        $command = $connection->createCommand();
        $command->insert('db_ci.destinocomunicacao_dest', array('dest_codcomunicacao'=>$encaminhamentos->dest_codcomunicacao, 'dest_codcolaborador'=>$encaminhamentos->dest_codcolaborador, 'dest_codunidadeenvio'=>$encaminhamentos->dest_codunidadeenvio, 'dest_codunidadedest'=>$cod_unidade, 'dest_data'=>date('Y-m-d H:i:s'), 'dest_codtipo'=>3, 'dest_codsituacao'=>1, 'dest_coddespacho'=>0, 'dest_nomeunidadeenvio'=>$session['sess_unidade'],'dest_nomeunidadedest'=>$nomeUnidade ));
        $command->execute();
           }
       }

            //instacia um novo despacho
            $despachos = new Despachos();
            $despachos->deco_codcomunicacao = $model->dest_codcomunicacao;
            $despachos->deco_codcolaborador = $session['sess_codcolaborador'];
            $despachos->deco_codunidade = $session['sess_codunidade'];
            $despachos->deco_codcargo = $session['sess_codcargo'];
            $despachos->deco_data = date('Y-m-d H:i:s');
            $despachos->deco_codsituacao = $model->dest_codsituacao;
            $despachos->deco_nomeunidade = $session['sess_unidade'];
            $despachos->deco_nomeusuario = $session['sess_nomeusuario'];
            $despachos->deco_cargo = $session['sess_cargo'];

                                                                                
         if ($despachos->load(Yii::$app->request->post()) && $despachos->save()) 
        {  
                //GRAVAR ANEXOS
                           
                            if (!empty($_POST)) {

                                $model->file = UploadedFile::getInstances($model, 'file');

                                $subdiretorio = "uploads/" . $model->dest_codcomunicacao . "/" . $despachos->deco_coddespacho;

                                                if(!file_exists($subdiretorio))
                                                {
                                                  if(!mkdir($subdiretorio));
                                                }
                                                             if ($model->file){
                                                            foreach ($model->file as $file)
                                                                 {
                                                                     $file->saveAs($subdiretorio.'/'. $file->baseName . '.' . $file->extension);

                                                                    $model->dest_anexo = $subdiretorio.'/';
                                                                    $model->save();
                                                                 }
                                                        }
                                                    }

            $model->dest_coddespacho = $despachos->deco_coddespacho;
            $encaminhamentos->dest_coddespacho = $model->dest_coddespacho;

                    //Atualiza a situação do DESTINO para "ABERTO"(cód 3) e insere o código de despacho para poder realizar a filtragem e enviar o e-mail"
                    $connection = Yii::$app->db;
                    $command = $connection->createCommand(
                    "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codsituacao` = '3' WHERE `dest_coddestino` = '".$model->dest_coddestino."' AND `dest_codcomunicacao` =" . $session['sess_comunicacao']);
                    $command->execute();

                    //Atualiza a situação do ENCAMINHAMENTO para "ABERTO"(cód 2), CASO HAJA ALGUM ENCAMINHAMENTO"
                    $command = $connection->createCommand(
                    "UPDATE destinocomunicacao_dest SET dest_codsituacao = '2', `dest_coddespacho` = '".$model->dest_coddespacho."' WHERE dest_codcomunicacao = '".$session['sess_comunicacao']."' AND dest_nomeunidadeenvio = '".$session['sess_unidade']."' AND dest_codsituacao = 1");  
                    $command->execute();

                    //Atualiza os destinos que estão duplicados e encerra os mesmos
                    $command = $connection->createCommand(
                    "UPDATE destinocomunicacao_dest SET dest_codsituacao = '3' WHERE dest_codcomunicacao = '".$session['sess_comunicacao']."' AND dest_codunidadedest = '".$model->dest_codunidadedest."' AND dest_codsituacao = 2");  
                    $command->execute();

         //ENVIA EMAIL PARA TODAS AS UNIDADES QUE FORAM INSERIDAS NO DESTINO DA CI
         //CRIANDO ARRAY COM SETORES PARTICIPANTES DA CI....
         //
         //
         //ENVIO DE E-MAIL PARA OS GERENTES RETIRANDO A DUPLICIDADE DO ENVIO NO ENVIO CASO ALGUM GERENTE NÃO TENHA DESPACHADO
          $sql_unidade_destino = "SELECT DISTINCT dest_nomeunidadedest,dest_codcomunicacao,dest_codunidadedest FROM destinocomunicacao_dest WHERE dest_codtipo = '3' AND dest_codsituacao = '2' AND dest_codcomunicacao = ".$model->dest_codcomunicacao;

                 $unidades = Destinocomunicacao::findBySql($sql_unidade_destino)->all();
                 foreach ($unidades as $unidade)
                    {
                     $id_ci  = $unidade["dest_codcomunicacao"];
                     $unidade_destino  = $unidade["dest_codunidadedest"];
                     $nomeunidade_destino  = $unidade["dest_nomeunidadedest"];
                   
                  
                $sql_email_unidade = "SELECT DISTINCT `db_base`.`emailusuario_emus`.`emus_email` FROM `db_base`.`usuario_usu`, `db_base`.`emailusuario_emus`, `db_base`.`responsavelambiente_ream`, `db_base`.`colaborador_col` WHERE ream_codunidade = '".$unidade_destino."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = usu_codusuario and usu_codusuario = emus_codusuario";  
      
                          $email_unidades = Emailusuario::findBySql($sql_email_unidade)->all();
                          foreach ($email_unidades as $email_unidade)
                                       {
                                         $email_unidade_gerente  = $email_unidade["emus_email"];

                                                Yii::$app->mailer->compose()
                                                ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                                                ->setTo($email_unidade_gerente)
                                                ->setSubject('CI '.$id_ci. ' Aguardando Despacho - ' .$nomeunidade_destino)
                                                ->setTextBody('Existe uma CI de código: '.$id_ci.' aguardando seu despacho')
                                                ->setHtmlBody('<p>Prezado(a)&nbsp;Gerente,</p>

                                                <p>Existe uma Comunica&ccedil;&atilde;o Interna <span style="color:#337AB7">'.$id_ci.' </span>aguardando seu despacho. Abaixo, segue o respons&aacute;vel que realizou o o&nbsp;&uacute;ltimo despacho:</p>

                                                <p><strong>Despachado por: </strong><span style="color:#337AB7">'.$despachos->deco_nomeusuario.'</span></p>

                                                <p><strong>Data/Hora</strong>:&nbsp;<span style="color:#337AB7">'.date('d/m/Y H:i', strtotime($despachos->deco_data)).'</span></p>

                                                ')
                                                ->send();
            
                      }

           }

            if($despachos->save()){

                Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Foi realizado o <strong>Despacho</strong> da Comunicação Interna de código: ' . '<strong>' .$model->dest_codcomunicacao. '</strong>');
             return $this->redirect(['index']);
         }
        } else {
            return $this->render('update', [
                'model' => $model,
                'despachos' => $despachos,
                'encaminhamentos' => $encaminhamentos,
                'searchModel' => $searchModel,
                'searchEncModel' => $searchEncModel,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
            ]);
        }
        
    }

    /**
     * Deletes an existing Destinocomunicacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

                //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $checar_destino = DestinocomunicacaoEnc::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->count();

                        if($model = DestinocomunicacaoEnc::findOne($id)){
                     
                      if($model->delete()) {

                          Yii::$app->getSession()->setFlash('danger', [
                               'type' => 'danger',
                               'duration' => 5000,
                               'icon' => 'glyphicon glyphicon-info-sign',
                               'message' => 'Encaminhamento excluido com sucesso!',
                               'title' => 'Exclusão',
                               'positonY' => 'top',
                               'positonX' => 'right'
                           ]);
                            $session = Yii::$app->session;
                             return $this->redirect(['update', 'id' => $session['sess_destino']]);       
                        }                          
                }

    }


    public function actionEncerrar($id)
    {
    $session = Yii::$app->session;

    $model = $this->findModel($id);

                //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $comunicacaointerna = Comunicacaointerna::find($id)
                ->where(['com_codcomunicacao' => $model->dest_codcomunicacao])
                ->one();

    
    $comunicacaointerna->com_usuarioEncerramento = $session['sess_nomeusuario'];
    $comunicacaointerna->com_dataEncerramento = date('Y-m-d H:i:s');


    //encerra a comunicacao que está em Circulação
    $connection = Yii::$app->db;
    $command = $connection->createCommand(
    "UPDATE `db_ci`.`comunicacaointerna_com` SET `com_codsituacao` = '5', `com_usuarioEncerramento` = '".$comunicacaointerna->com_usuarioEncerramento."', `com_dataEncerramento` = '".$comunicacaointerna->com_dataEncerramento."'  WHERE `com_codcomunicacao` = ".$model->dest_codcomunicacao."");
    $command->execute();

         //ENVIO DE E-MAIL PARA OS GERENTES RETIRANDO A DUPLICIDADE DO ENVIO INFORMANDO SOBRE O ENCERRAMENTO
          $sql_unidade_destino = "SELECT DISTINCT dest_nomeunidadedest,dest_codcomunicacao,dest_codunidadedest FROM destinocomunicacao_dest WHERE dest_codcomunicacao = ".$model->dest_codcomunicacao;

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

                                                <p><strong>Respons&aacute;vel pelo Encerramento</strong>:<span style="color:#337AB7"><strong> '.$comunicacaointerna->com_usuarioEncerramento.'</strong></span></p>

                                                <p><strong>Data do Encerramento</strong>: <span style="color:#337AB7"><strong> '.date('d/m/Y H:i', strtotime($comunicacaointerna->com_dataEncerramento)).'</strong></span></p>

                                                <p><i><strong>Por favor, n&atilde;o responda esse e-mail. Acesse http://portalsenac.am.senac.br</strong></i></p>

                                                <p>Atenciosamente,&nbsp;</p>

                                                <p>Sistema Gerenciador de Documentação Eletrônica</p>')
                                                ->send();
            
                      }

           }

    Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Comunicação Interna de código: ' . '<strong>' .$model->dest_codcomunicacao. '</strong> foi <strong>ENCERRADA!</strong>');
     
return $this->redirect(['index']);

}
    /**
     * Finds the Destinocomunicacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Destinocomunicacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destinocomunicacao::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
