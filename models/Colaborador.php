<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colaborador_col".
 *
 * @property string $col_codcolaborador
 * @property string $col_codusuario
 * @property string $col_codunidade
 * @property string $col_coddepartamento
 * @property string $col_codcargo
 * @property string $col_codsituacao
 *
 * @property CargosCar $colCodcargo
 * @property DepartamentoDep $colCoddepartamento
 * @property SituacaosistemaSitsis $colCodsituacao
 * @property UnidadeUni $colCodunidade
 * @property UsuarioUsu $colCodusuario
 * @property FuncaocolaboradorFuco[] $funcaocolaboradorFucos
 * @property FuncaomoduloFumo[] $fucoCodfuncaos
 * @property LocalizacaoLoc[] $localizacaoLocs
 * @property ModulocolaboradorMoco[] $modulocolaboradorMocos
 * @property ModulosMod[] $mocoCodmodulos
 * @property ResponsavelambienteReam[] $responsavelambienteReams
 * @property UnidadeUni[] $reamCodunidades
 * @property ResponsaveldepartamentoRede[] $responsaveldepartamentoRedes
 * @property DepartamentoDep[] $redeCoddepartamentos
 */
class Colaborador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colaborador_col';
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
            [['col_codusuario', 'col_codunidade', 'col_coddepartamento', 'col_codcargo', 'col_codsituacao'], 'required'],
            [['col_codusuario', 'col_codunidade', 'col_coddepartamento', 'col_codcargo', 'col_codsituacao'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'col_codcolaborador' => 'Col Codcolaborador',
            'col_codusuario' => 'Col Codusuario',
            'col_codunidade' => 'Col Codunidade',
            'col_coddepartamento' => 'Col Coddepartamento',
            'col_codcargo' => 'Col Codcargo',
            'col_codsituacao' => 'Col Codsituacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColCodcargo()
    {
        return $this->hasOne(CargosCar::className(), ['car_codcargo' => 'col_codcargo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColCoddepartamento()
    {
        return $this->hasOne(DepartamentoDep::className(), ['dep_coddepartamento' => 'col_coddepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColCodsituacao()
    {
        return $this->hasOne(SituacaosistemaSitsis::className(), ['sitsis_codsituacao' => 'col_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColCodunidade()
    {
        return $this->hasOne(UnidadeUni::className(), ['uni_codunidade' => 'col_codunidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuarioUsu::className(), ['usu_codusuario' => 'col_codusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFuncaocolaboradorFucos()
    {
        return $this->hasMany(FuncaocolaboradorFuco::className(), ['fuco_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFucoCodfuncaos()
    {
        return $this->hasMany(FuncaomoduloFumo::className(), ['fumo_codfuncao' => 'fuco_codfuncao'])->viaTable('funcaocolaborador_fuco', ['fuco_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaoLocs()
    {
        return $this->hasMany(LocalizacaoLoc::className(), ['loc_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulocolaboradorMocos()
    {
        return $this->hasMany(ModulocolaboradorMoco::className(), ['moco_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMocoCodmodulos()
    {
        return $this->hasMany(ModulosMod::className(), ['mod_codmodulo' => 'moco_codmodulo'])->viaTable('modulocolaborador_moco', ['moco_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavelambienteReams()
    {
        return $this->hasMany(ResponsavelambienteReam::className(), ['ream_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReamCodunidades()
    {
        return $this->hasMany(UnidadeUni::className(), ['uni_codunidade' => 'ream_codunidade'])->viaTable('responsavelambiente_ream', ['ream_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsaveldepartamentoRedes()
    {
        return $this->hasMany(ResponsaveldepartamentoRede::className(), ['rede_codcolaborador' => 'col_codcolaborador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedeCoddepartamentos()
    {
        return $this->hasMany(DepartamentoDep::className(), ['dep_coddepartamento' => 'rede_coddepartamento'])->viaTable('responsaveldepartamento_rede', ['rede_codcolaborador' => 'col_codcolaborador']);
    }
}
