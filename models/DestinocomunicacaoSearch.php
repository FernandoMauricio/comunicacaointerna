<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Destinocomunicacao;

/**
 * DestinocomunicacaoSearch represents the model behind the search form about `app\models\Destinocomunicacao`.
 */
class DestinocomunicacaoSearch extends Destinocomunicacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dest_coddestino', 'dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codunidadedest', 'dest_codtipo', 'dest_codsituacao'], 'integer'],
            [['dest_data'], 'safe'],
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
        $query = Destinocomunicacao::find();

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
            'dest_coddestino' => $this->dest_coddestino,
            'dest_codcomunicacao' => $this->dest_codcomunicacao,
            'dest_codcolaborador' => $this->dest_codcolaborador,
            'dest_codunidadeenvio' => $this->dest_codunidadeenvio,
            'dest_codunidadedest' => $this->dest_codunidadedest,
            'dest_data' => $this->dest_data,
            'dest_codtipo' => $this->dest_codtipo,
            'dest_codsituacao' => $this->dest_codsituacao,
        ]);

        return $dataProvider;
    }
}
