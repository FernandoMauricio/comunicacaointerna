<?php

namespace app\controllers;

use Yii;
use app\models\Destinocomunicacao;
use app\models\ComunicacaointernaAut;
use app\models\ComunicacaointernaAutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComunicacaointernaAutController implements the CRUD actions for ComunicacaointernaAut model.
 */
class ComunicacaointernaAutController extends Controller
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
     * Lists all ComunicacaointernaAut models.
     * @return mixed
     */
    public function actionIndex()
    {
                        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }


        $destinocomunicacao = new Destinocomunicacao();
        $searchModel = new ComunicacaointernaAutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if (Yii::$app->request->post('hasEditable')) {

        // instantiate your ComunicacaointernaAut model for saving
        $comunicacaointernaAut = Yii::$app->request->post('editableKey');
        $model = ComunicacaointernaAut::findOne($comunicacaointernaAut);
 
        $post = [];
        $posted = current($_POST['ComunicacaointernaAut']);
        $post['ComunicacaointernaAut'] = $posted;
 
        // load model like any single model validation
        if ($model->load($post)) {
            $session = Yii::$app->session;
            $model->com_dataautorizacao = date('Y-m-d H:i:s');
            $model->com_codcolaboradorautorizacao = $session['sess_codcolaborador'];
            $model->com_codcargoautorizacao = $session['sess_codcargo'];
            // can save model or do something before saving model
            $model->save();              

            // similarly you can check if the name attribute was posted as well
             if($posted['com_codsituacao'] == 4)
              {
                //Atualiza a situação do destino para "ABERTO"(cód 2) para poder realizar a filtragem e enviar o e-mail"
                $connection = Yii::$app->db;
                $command = $connection->createCommand(
                 "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codsituacao` = '2' WHERE `destinocomunicacao_dest`.`dest_codcomunicacao` =" . $_POST['editableKey']);
                $command->execute();
                //$output =  'Aprovado'; // process as you need
                Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 5000,
                         'icon' => 'glyphicon glyphicon-ok',
                         'message' => 'Comunicação interna aprovada com sucesso!',
                         'title' => 'Aprovação',
                         'positonY' => 'top',
                         'positonX' => 'right'
                     ]);
              
             }else
                if($posted['com_codsituacao'] == 1)
              {
                //$output =  'Reprovado';
                    Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 5000,
                         'icon' => 'glyphicon glyphicon-remove',
                         'message' => 'Comunicação interna reprovada com sucesso!',
                         'title' => 'Reprovação',
                         'positonY' => 'top',
                         'positonX' => 'right'
                     ]);
            }
                //            //VERIFICAR COMO MUDAR A SITUAÇÃO PARA CÓDIGO 2.....
                // $destinocomunicacao = Destinocomunicacao::find($model['com_codcomunicacao']);
                // $destinocomunicacao->dest_codsituacao = 2;
                // $destinocomunicacao->save(); 
        return $this->redirect(['index']);
        } 
         
    }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'destinocomunicacao'=> $destinocomunicacao,
        ]);
    }

    /**
     * Displays a single ComunicacaointernaAut model.
     * @param integer $id
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
     * Creates a new ComunicacaointernaAut model.
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

        $model = new ComunicacaointernaAut();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->com_codcomunicacao]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ComunicacaointernaAut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->com_codcomunicacao]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ComunicacaointernaAut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ComunicacaointernaAut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComunicacaointernaAut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComunicacaointernaAut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
