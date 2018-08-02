<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AnexosModel;

/**
 * AnexosModelSearch represents the model behind the search form about `app\models\AnexosModel`.
 */
class AnexosModelSearch extends AnexosModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ane_codanexo', 'ane_codcomunicacao'], 'integer'],
            [['ane_arquivo'], 'safe'],
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
        $query = AnexosModel::find();

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
            'ane_codanexo' => $this->ane_codanexo,
            'ane_codcomunicacao' => $this->ane_codcomunicacao,
        ]);

        $query->andFilterWhere(['like', 'ane_arquivo', $this->ane_arquivo]);

        return $dataProvider;
    }
}
