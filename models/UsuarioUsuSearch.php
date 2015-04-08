<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioUsu;

/**
 * UsuarioUsuSearch represents the model behind the search form about `app\models\UsuarioUsu`.
 */
class UsuarioUsuSearch extends UsuarioUsu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usu_codusuario', 'usu_codtipo', 'usu_codsituacao'], 'integer'],
            [['usu_loginusuario', 'usu_senhausuario', 'usu_nomeusuario'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UsuarioUsu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'usu_codusuario' => $this->usu_codusuario,
            'usu_codtipo' => $this->usu_codtipo,
            'usu_codsituacao' => $this->usu_codsituacao,
        ]);

        $query->andFilterWhere(['like', 'usu_loginusuario', $this->usu_loginusuario])
            ->andFilterWhere(['like', 'usu_senhausuario', $this->usu_senhausuario])
            ->andFilterWhere(['like', 'usu_nomeusuario', $this->usu_nomeusuario]);

        return $dataProvider;
    }
}
