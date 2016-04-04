<?php

namespace app\controllers;

use Yii;
use app\models\Unidades;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * DestinocomunicacaoController implements the CRUD actions for Destinocomunicacao model.
 */
class DestinocomunicacaoController extends Controller
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


            $destinocomunicacao = new Destinocomunicacao();

             if ($destinocomunicacao->load(Yii::$app->request->post()) && $destinocomunicacao->save())
             {
                  $destinocomunicacao = new Destinocomunicacao(); //reset model
             }

        $searchModel = new DestinocomunicacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'destinocomunicacao' => $destinocomunicacao,

        ]);
    }

    /**
     * Displays a single Destinocomunicacao model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'destinocomunicacao' => $this->findModel($id),
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


        //conexão com os bancos
         $connection = Yii::$app->db;
         $connection = Yii::$app->db_base;

        $destinocomunicacao = new Destinocomunicacao();

                $searchModel = new DestinocomunicacaoSearch();
                 $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($destinocomunicacao->load(Yii::$app->request->post()) && $destinocomunicacao->save()) {
            return $this->redirect(['view', 'id' => $destinocomunicacao->dest_coddestino]);
        } else {
            return $this->render('create', [
                'destinocomunicacao' => $destinocomunicacao,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'destinocomunicacao' => $destinocomunicacao,
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
        
        $destinocomunicacao = $this->findModel($id);

        if ($destinocomunicacao->load(Yii::$app->request->post()) && $destinocomunicacao->save()) {
            return $this->redirect(['view', 'id' => $destinocomunicacao->dest_coddestino]);
        } else {
            return $this->render('update', [
                'destinocomunicacao' => $destinocomunicacao,
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
        $this->findModel($id)->delete();

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
        if (($destinocomunicacao = Destinocomunicacao::findOne($id)) !== null) {
            return $destinocomunicacao;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}