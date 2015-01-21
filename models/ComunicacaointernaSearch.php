<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ComunicacaoInternaCom;

/**
 * ComunicacaointernaSearch represents the model behind the search form about `app\models\ComunicacaoInternaCom`.
 */
class ComunicacaointernaSearch extends ComunicacaoInternaCom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_codcomunicacao', 'com_codcolaborador', 'com_codunidade', 'com_codtipo', 'com_codsituacao', 'com_codcolaboradorautorizacao', 'com_codcargoautorizacao'], 'integer'],
            [['com_datasolicitacao', 'com_titulo', 'com_texto', 'com_dataautorizacao'], 'safe'],
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
        $query = ComunicacaoInternaCom::find();

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
            'com_codcomunicacao' => $this->com_codcomunicacao,
            'com_codcolaborador' => $this->com_codcolaborador,
            'com_codunidade' => $this->com_codunidade,
            'com_datasolicitacao' => $this->com_datasolicitacao,
            'com_codtipo' => $this->com_codtipo,
            'com_codsituacao' => $this->com_codsituacao,
            'com_dataautorizacao' => $this->com_dataautorizacao,
            'com_codcolaboradorautorizacao' => $this->com_codcolaboradorautorizacao,
            'com_codcargoautorizacao' => $this->com_codcargoautorizacao,
        ]);

        $query->andFilterWhere(['like', 'com_titulo', $this->com_titulo])
            ->andFilterWhere(['like', 'com_texto', $this->com_texto]);

        return $dataProvider;
    }
}
