<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comunicacaointerna;

/**
 * ComunicacaointernaSearch represents the model behind the search form about `app\models\Comunicacaointerna`.
 */
class ComunicacaointernaSearch extends ComunicacaoInterna
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_codcomunicacao', 'com_codunidade', 'com_codcolaboradorautorizacao', 'com_codcargoautorizacao'], 'integer'],
            [['com_datasolicitacao', 'com_codtipo', 'com_codsituacao', 'com_titulo', 'com_texto', 'com_dataautorizacao', 'com_codcolaborador'], 'safe'],
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

        $query = ComunicacaoInterna::find()
        ->orderBy(['com_codcomunicacao' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //conexão com os bancos
         $connection = Yii::$app->db;
         $connection = Yii::$app->db_base;

        $query->joinWith('comCodtipo');
        $query->joinWith('situacao');
        
        $query->andFilterWhere([
            'com_codcomunicacao' => $this->com_codcomunicacao,
            'com_codunidade' => $this->com_codunidade,
            'com_datasolicitacao' => $this->com_datasolicitacao,
            'com_dataautorizacao' => $this->com_dataautorizacao,
            'com_codcolaboradorautorizacao' => $this->com_codcolaboradorautorizacao,
            'com_codcargoautorizacao' => $this->com_codcargoautorizacao,
        ]);

//Coletar a sessão do usuário
 $session = Yii::$app->session;

        $query->andFilterWhere(['like', 'com_titulo', $this->com_titulo])
            ->andFilterWhere(['com_codunidade' => $session['sess_codunidade']])
            ->andFilterWhere(['like', 'tipodocumentacao_tipdo.tipdo_tipo', $this->com_codtipo])
            ->andFilterWhere(['like', 'situacaocomunicacao_sitco.sitco_situacao1', $this->com_codsituacao])
            ->andFilterWhere(['like', 'com_texto', $this->com_texto]);

        return $dataProvider;
    }
}
