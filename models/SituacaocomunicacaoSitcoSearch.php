<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SituacaocomunicacaoSitco;

/**
 * SituacaocomunicacaoSitcoSearch represents the model behind the search form about `app\models\SituacaocomunicacaoSitco`.
 */
class SituacaocomunicacaoSitcoSearch extends SituacaocomunicacaoSitco
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sitco_codsituacao'], 'integer'],
            [['sitco_situacao1', 'sitco_situacao2'], 'safe'],
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
        $query = SituacaocomunicacaoSitco::find();

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
            'sitco_codsituacao' => $this->sitco_codsituacao,
        ]);

        $query->andFilterWhere(['like', 'sitco_situacao1', $this->sitco_situacao1])
            ->andFilterWhere(['like', 'sitco_situacao2', $this->sitco_situacao2]);

        return $dataProvider;
    }
}
