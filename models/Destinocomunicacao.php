<?php

namespace app\models;

use Yii;
use yii\db\Expression;


/**
 * This is the model class for table "destinocomunicacao_dest".
 *
 * @property string $dest_coddestino
 * @property string $dest_codcomunicacao
 * @property integer $dest_codcolaborador
 * @property integer $dest_codunidadeenvio
 * @property integer $dest_codunidadedest
 * @property string $dest_data
 * @property string $dest_codtipo
 * @property string $dest_codsituacao
 *
 * @property Comunicacaointerna $destCodcomunicacao
 * @property SituacaodestinoSide $destCodsituacao
 * @property TipodestinoTipde $destCodtipo
 */
class Destinocomunicacao extends \yii\db\ActiveRecord
{

public $file;
public $titulo;
public $tipo;
public $data_solicitacao;
public $situacao;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destinocomunicacao_dest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['dest_codcomunicacao', 'dest_codsituacao', 'dest_nomeunidadedest','dest_coddespacho'], 'unique', 'targetAttribute' => ['dest_codcomunicacao',  'dest_codsituacao', 'dest_nomeunidadedest','dest_coddespacho']],
            //[['dest_codcomunicacao',  'dest_nomeunidadedest','dest_coddespacho'], 'unique', 'targetAttribute' => ['dest_codcomunicacao', 'dest_nomeunidadedest','dest_coddespacho'], 'message' => '"{value}" Já está inserido na CI e ainda não realizou o despacho!'],
            [['titulo', 'tipo', 'data_solicitacao', 'situacao', 'dest_nomeunidadedest','dest_nomeunidadedestCopia'], 'safe'],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio','dest_codtipo', 'dest_codsituacao','dest_nomeunidadedest'], 'required'],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codunidadedest', 'dest_codtipo', 'dest_codsituacao'], 'integer'],
            [['dest_nomeunidadeenvio', 'dest_anexo'],  'string', 'max' => 100 ],
            [['file'], 'file', 'maxFiles' => 10,'checkExtensionByMimeType'=>false, 'extensions' => 'pdf, zip, rar, doc, docx'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dest_coddestino' => 'Código Destino',
            'dest_codcomunicacao' => 'Cód.',
            'dest_codcolaborador' => 'Código Colaborador',
            'dest_codunidadeenvio' => 'Código da Unidade',
            'dest_data' => 'Data',
            'data_solicitacao' => 'Data da Solicitação',
            'titulo' => 'Título',
            'tipo' => 'Tipo',
            'situacao' => 'Situação',
            'dest_codtipo' => 'Tipo',
            'dest_codsituacao' => 'Situação',
            'dest_nomeunidadeenvio' => 'Unidade',
            'dest_nomeunidadedest' => 'Destino',
            'dest_nomeunidadedestCopia' => 'Com Cópia Para',
            'file' => 'Anexos',
        ];
    }

// public function beforeSave($insert)
//         {       
//         $dest_nomeunidadedestModel = implode(",", $this->dest_nomeunidadedest);
//         $this->dest_nomeunidadedest = $dest_nomeunidadedestModel;
//         return parent::beforeSave($insert);
//         }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunicacaointerna()
    {
        return $this->hasOne(Comunicacaointerna::className(), ['com_codcomunicacao' => 'dest_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestCodsituacao()
    {
        return $this->hasOne(SituacaodestinoSide::className(), ['side_codsituacao' => 'dest_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestCodtipo()
    {
        return $this->hasOne(TipodestinoTipde::className(), ['tipde_codtipo' => 'dest_codtipo']);
    }

    public function getUnidades()
    {
        return $this->hasOne(Unidades::className(),['uni_nomeabreviado' => 'dest_nomeunidadedest']);
    }

    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'dest_codcolaborador']);
    }

}

