<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unidades;

/**
 * UnidadesSearch represents the model behind the search form about `app\models\Unidades`.
 */
class UnidadesSearch extends Unidades
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uni_codunidade', 'uni_coddisp', 'uni_codtipo', 'uni_codsituacao', 'uni_codtipres', 'uni_permitirmodeloa'], 'integer'],
            [['uni_nomecompleto', 'uni_nomeabreviado', 'uni_cnpj', 'uni_cep', 'uni_logradouro', 'uni_bairro', 'uni_cidade', 'uni_estado'], 'safe'],
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
        $query = Unidades::find();

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
            'uni_codunidade' => $this->uni_codunidade,
            'uni_coddisp' => $this->uni_coddisp,
            'uni_codtipo' => $this->uni_codtipo,
            'uni_codsituacao' => $this->uni_codsituacao,
            'uni_codtipres' => $this->uni_codtipres,
            'uni_permitirmodeloa' => $this->uni_permitirmodeloa,
        ]);

        $query->andFilterWhere(['like', 'uni_nomecompleto', $this->uni_nomecompleto])
            ->andFilterWhere(['like', 'uni_nomeabreviado', $this->uni_nomeabreviado])
            ->andFilterWhere(['like', 'uni_cnpj', $this->uni_cnpj])
            ->andFilterWhere(['like', 'uni_cep', $this->uni_cep])
            ->andFilterWhere(['like', 'uni_logradouro', $this->uni_logradouro])
            ->andFilterWhere(['like', 'uni_bairro', $this->uni_bairro])
            ->andFilterWhere(['like', 'uni_cidade', $this->uni_cidade])
            ->andFilterWhere(['like', 'uni_estado', $this->uni_estado]);

        return $dataProvider;
    }
}
