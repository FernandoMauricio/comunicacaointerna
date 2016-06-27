<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Destinocomunicacao;
use app\models\Comunicacaointerna;

/**
 * DestinocomunicacaoCircSearch represents the model behind the search form about `app\models\Destinocomunicacao`.
 */
class DestinocomunicacaoCircSearch extends Destinocomunicacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dest_coddestino', 'dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codtipo', 'dest_codsituacao', 'dest_coddespacho'], 'integer'],
            [['dest_data', 'dest_nomeunidadeenvio', 'dest_nomeunidadedest', 'titulo', 'tipo', 'data_solicitacao', 'situacao'], 'safe'],
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
        $query = Destinocomunicacao::find()->select(['dest_codcomunicacao', 'dest_codunidadedest'])->distinct()
        ->orderBy(['dest_coddestino' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['titulo'] = [
        'asc' => ['comunicacaointerna_com.com_titulo' => SORT_ASC],
        'desc' => ['comunicacaointerna_com.com_titulo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['tipo'] = [
        'asc' => ['comunicacaointerna_com.com_tipo' => SORT_ASC],
        'desc' => ['comunicacaointerna_com.com_tipo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['data_solicitacao'] = [
        'asc' => ['comunicacaointerna_com.com_datasolicitacao' => SORT_ASC],
        'desc' => ['comunicacaointerna_com.com_datasolicitacao' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['situacao'] = [
        'asc' => ['comunicacaointerna_com.com_codsituacao' => SORT_ASC],
        'desc' => ['comunicacaointerna_com.com_codsituacao' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('comunicacaointerna.comCodtipo');
        $query->joinWith('comunicacaointerna');

        $query->andFilterWhere([
            'dest_coddestino' => $this->dest_coddestino,
            'dest_codcomunicacao' => $this->dest_codcomunicacao,
            'dest_codcolaborador' => $this->dest_codcolaborador,
            'dest_codunidadeenvio' => $this->dest_codunidadeenvio,
            //'dest_codunidadedest' => $this->dest_codunidadedest,
            'dest_data' => $this->dest_data,
            'dest_codtipo' => $this->dest_codtipo,
            'dest_codsituacao' => $this->dest_codsituacao,
            'dest_coddespacho' => $this->dest_coddespacho,
            
        ]);

        //Coletar a sessão do usuário
        $session = Yii::$app->session;

        $query->andFilterWhere(['like', 'dest_codunidadeenvio', $this->dest_codunidadeenvio])
            ->andFilterWhere(['like', 'dest_nomeunidadeenvio', $this->dest_nomeunidadeenvio])
            ->andFilterWhere(['like', 'comunicacaointerna_com.com_titulo', $this->titulo])
            ->andFilterWhere(['=', 'tipodocumentacao_tipdo.tipdo_tipo', $this->tipo])
            ->andFilterWhere(['like', 'comunicacaointerna_com.com_datasolicitacao', $this->data_solicitacao])
            ->andFilterWhere(['=', 'comunicacaointerna_com.com_codsituacao', $this->situacao])
            ->andFilterWhere(['comunicacaointerna_com.com_codsituacao' => 4])
            ->andFilterWhere(['dest_codunidadedest' => $session['sess_codunidade']])
            ->andFilterWhere(['dest_codtipo' => [2,3]])
            ->andFilterWhere(['dest_codsituacao' => 2]);

        return $dataProvider;
    }
}
