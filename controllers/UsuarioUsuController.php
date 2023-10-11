<?php

namespace app\controllers;

use Yii;
use app\models\UsuarioUsu;
use app\models\UsuarioUsuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioUsuController implements the CRUD actions for UsuarioUsu model.
 */
class UsuarioUsuController extends Controller
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
     * Updates an existing UsuarioUsu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $session = Yii::$app->session;

        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('https://portalsenac.am.senac.br');
        }
        
        if($model->usu_codusuario != $session['sess_codusuario']){

            throw new NotFoundHttpException('The requested page does not exist.');
        }else{
       
        $model->usu_senhausuario = NULL;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->usu_senhausuario = base64_encode($model->usu_senhausuario);
            $model->passwordConfirm = base64_encode($model->passwordConfirm);
            $model->save();

                Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> A senha foi <strong>ALTERADA!</strong>');

            return $this->redirect(['site/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
    /**
     * Finds the UsuarioUsu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsuarioUsu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioUsu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
