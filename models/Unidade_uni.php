<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidade_uni".
 *
 * @property string $uni_codunidade
 * @property string $uni_nomecompleto
 * @property string $uni_nomeabreviado
 * @property string $uni_cnpj
 * @property string $uni_cep
 * @property string $uni_logradouro
 * @property string $uni_bairro
 * @property string $uni_cidade
 * @property string $uni_estado
 * @property string $uni_coddisp
 * @property string $uni_codtipo
 * @property string $uni_codsituacao
 * @property string $uni_codtipres
 * @property integer $uni_permitirmodeloa
 *
 * @property CentrocustoCen[] $centrocustoCens
 * @property ColaboradorCol[] $colaboradorCols
 * @property DepartamentoDep[] $departamentoDeps
 * @property LocalizacaoLoc[] $localizacaoLocs
 * @property ResponsavelambienteReam[] $responsavelambienteReams
 * @property ColaboradorCol[] $reamCodcolaboradors
 * @property DisponibilizarsiteDisp $uniCoddisp
 * @property SituacaosistemaSitsis $uniCodsituacao
 * @property TipounidadeTiun $uniCodtipo
 * @property TiporesponsavelTire $uniCodtipres
 */
class Unidade_uni extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidade_uni';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_base');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uni_nomecompleto', 'uni_nomeabreviado', 'uni_coddisp', 'uni_codtipo', 'uni_codsituacao', 'uni_codtipres'], 'required'],
            [['uni_coddisp', 'uni_codtipo', 'uni_codsituacao', 'uni_codtipres', 'uni_permitirmodeloa'], 'integer'],
            [['uni_nomecompleto'], 'string', 'max' => 150],
            [['uni_nomeabreviado'], 'string', 'max' => 60],
            [['uni_cnpj'], 'string', 'max' => 45],
            [['uni_cep'], 'string', 'max' => 15],
            [['uni_logradouro'], 'string', 'max' => 90],
            [['uni_bairro'], 'string', 'max' => 80],
            [['uni_cidade'], 'string', 'max' => 70],
            [['uni_estado'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uni_codunidade' => 'Código',
            'uni_nomecompleto' => 'Nome Completo',
            'uni_nomeabreviado' => 'Nome Abreviado',
            'uni_cnpj' => 'CNPJ',
            'uni_cep' => 'CEP',
            'uni_logradouro' => 'Endereço',
            'uni_bairro' => 'Bairro',
            'uni_cidade' => 'Cidade',
            'uni_estado' => 'Estado',
            'uni_coddisp' => 'Disp. Site',
            'uni_codtipo' => 'Tipo Unidade',
            'uni_codsituacao' => 'Situação',
            'uni_codtipres' => 'Tipo Responsavel',
            'uni_permitirmodeloa' => 'Uni Permitirmodeloa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrocustoCens()
    {
        return $this->hasMany(CentrocustoCen::className(), ['cen_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColaboradorCols()
    {
        return $this->hasMany(ColaboradorCol::className(), ['col_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentoDeps()
    {
        return $this->hasMany(DepartamentoDep::className(), ['dep_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaoLocs()
    {
        return $this->hasMany(LocalizacaoLoc::className(), ['loc_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavelambienteReams()
    {
        return $this->hasMany(ResponsavelambienteReam::className(), ['ream_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReamCodcolaboradors()
    {
        return $this->hasMany(ColaboradorCol::className(), ['col_codcolaborador' => 'ream_codcolaborador'])->viaTable('responsavelambiente_ream', ['ream_codunidade' => 'uni_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniCoddisp()
    {
        return $this->hasOne(DisponibilizarsiteDisp::className(), ['disp_coddisp' => 'uni_coddisp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniCodsituacao()
    {
        return $this->hasOne(SituacaosistemaSitsis::className(), ['sitsis_codsituacao' => 'uni_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniCodtipo()
    {
        return $this->hasOne(TipounidadeTiun::className(), ['tiun_codtipo' => 'uni_codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniCodtipres()
    {
        return $this->hasOne(TiporesponsavelTire::className(), ['tire_codtipo' => 'uni_codtipres']);
    }

    public function getComunicacoes()
    {
        return $this->hasMany(Comunicacaointerna::className(), ['com_codunidade' => 'uni_codunidade']);
    }

}
