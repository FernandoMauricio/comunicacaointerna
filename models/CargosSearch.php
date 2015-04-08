<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cargos;

/**
 * CargosSearch represents the model behind the search form about `app\models\Cargos`.
 */
class CargosSearch extends Cargos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_codcargo'], 'integer'],
            [['car_cargo'], 'safe'],
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
        $query = Cargos::find();

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
            'car_codcargo' => $this->car_codcargo,
        ]);

        $query->andFilterWhere(['like', 'car_cargo', $this->car_cargo]);

        return $dataProvider;
    }
}
