<?php

namespace app\controllers;

use Yii;
use app\models\Despachos;
use app\models\DespachosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DespachosController implements the CRUD actions for Despachos model.
 */
class DespachosController extends Controller
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
     * Lists all Despachos models.
     * @return mixed
     */
    public function actionIndex()
    {
                        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }

        $searchModel = new DespachosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Despachos model.
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
            'despachos' => $this->finddespachos($id),
        ]);
    }

    /**
     * Creates a new Despachos despachos.
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

        $despachos = new Despachos();

        if ($despachos->load(Yii::$app->request->post()) && $despachos->save()) {
            return $this->redirect(['view', 'id' => $despachos->deco_coddespacho]);
        } else {
            return $this->render('create', [
                'despachos' => $despachos,
            ]);
        }
    }

    /**
     * Updates an existing Despachos model.
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
        
        $despachos = $this->finddespachos($id);

        if ($despachos->load(Yii::$app->request->post()) && $despachos->save()) {
            return $this->redirect(['view', 'id' => $despachos->deco_coddespacho]);
        } else {
            return $this->render('update', [
                'despachos' => $despachos,
            ]);
        }
    }

    /**
     * Deletes an existing Despachos model.
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
     * Finds the Despachos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Despachos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($despachos = Despachos::findOne($id)) !== null) {
            return $despachos;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
