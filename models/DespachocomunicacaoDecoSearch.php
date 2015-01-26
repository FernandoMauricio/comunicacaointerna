<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DespachocomunicacaoDeco;

/**
 * DespachocomunicacaoDecoSearch represents the model behind the search form about `app\models\DespachocomunicacaoDeco`.
 */
class DespachocomunicacaoDecoSearch extends DespachocomunicacaoDeco
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deco_coddespacho', 'deco_codcomunicacao', 'deco_codcolaborador', 'deco_codunidade', 'deco_codcargo', 'deco_codsituacao'], 'integer'],
            [['deco_data', 'deco_despacho'], 'safe'],
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
        $query = DespachocomunicacaoDeco::find();

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
            'deco_coddespacho' => $this->deco_coddespacho,
            'deco_codcomunicacao' => $this->deco_codcomunicacao,
            'deco_codcolaborador' => $this->deco_codcolaborador,
            'deco_codunidade' => $this->deco_codunidade,
            'deco_codcargo' => $this->deco_codcargo,
            'deco_data' => $this->deco_data,
            'deco_codsituacao' => $this->deco_codsituacao,
        ]);

        $query->andFilterWhere(['like', 'deco_despacho', $this->deco_despacho]);

        return $dataProvider;
    }
}
