<?php

namespace app\controllers;

use Yii;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoCircSearch;
use app\models\DestinocomunicacaoPendenteCircSearch;
use app\models\Despachos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $model = new Destinocomunicacao();

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
        $model = $this->findModel($id);

        //Resgatando o código da CI para sql no banco
        $session = Yii::$app->session;
        $session->set('sess_comunicacao', $model->dest_codcomunicacao);
        $session->close();

        $searchModel = new DestinocomunicacaoPendenteCircSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



            //instacia um novo despacho
            $despachos = new Despachos();
            $despachos->deco_codcomunicacao = $model->dest_codcomunicacao;
            $despachos->deco_codcolaborador = $session['sess_codcolaborador'];
            $despachos->deco_codunidade = $session['sess_codunidade'];
            $despachos->deco_codcargo = $session['sess_codcargo'];
            $despachos->deco_data = date('Y-m-d h:m:s');
            $despachos->deco_codsituacao = $model->dest_codsituacao;
            $despachos->deco_nomeunidade = $session['sess_unidade'];
            $despachos->deco_nomeusuario = $session['sess_nomeusuario'];


         if ($despachos->load(Yii::$app->request->post()) && $despachos->save()) 
        {
            

            if($despachos->save())
            {
            $model->dest_coddespacho = $despachos->deco_coddespacho;
            $model->save();
            }
             return $this->redirect(['view', 'id' => $model->dest_codcomunicacao]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'despachos' => $despachos,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
        if (($model = Destinocomunicacao::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
