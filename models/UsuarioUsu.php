<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_usu".
 *
 * @property string $usu_codusuario
 * @property string $usu_loginusuario
 * @property string $usu_senhausuario
 * @property string $usu_nomeusuario
 * @property string $usu_codtipo
 * @property string $usu_codsituacao
 *
 * @property ColaboradorCol[] $colaboradorCols
 * @property EmailusuarioEmus[] $emailusuarioEmuses
 * @property FoneusuarioFous[] $foneusuarioFouses
 * @property LocalizacaoLoc[] $localizacaoLocs
 * @property SituacaosistemaSitsis $usuCodsituacao
 * @property TipousuarioTipusu $usuCodtipo
 */
class UsuarioUsu extends \yii\db\ActiveRecord
{
    public $passwordConfirm;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_usu';
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
            [['usu_loginusuario', 'usu_senhausuario', 'usu_nomeusuario', 'usu_codtipo', 'usu_codsituacao', 'passwordConfirm'], 'required'],
            [['usu_codtipo', 'usu_codsituacao'], 'integer'],
            [['passwordConfirm'], 'compare', 'compareAttribute' => 'usu_senhausuario'],
            [['usu_loginusuario', 'usu_senhausuario'], 'string', 'max' => 45],
            [['usu_nomeusuario'], 'string', 'max' => 50],
            [['usu_loginusuario'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usu_codusuario' => 'Usu Codusuario',
            'usu_loginusuario' => 'Login',
            'usu_senhausuario' => 'Nova Senha',
            'passwordConfirm' => 'Confirme a Nova Senha',
            'usu_nomeusuario' => 'Usu Nomeusuario',
            'usu_codtipo' => 'Usu Codtipo',
            'usu_codsituacao' => 'Usu Codsituacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColaboradorCols()
    {
        return $this->hasMany(ColaboradorCol::className(), ['col_codusuario' => 'usu_codusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailusuarioEmuses()
    {
        return $this->hasMany(EmailusuarioEmus::className(), ['emus_codusuario' => 'usu_codusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoneusuarioFouses()
    {
        return $this->hasMany(FoneusuarioFous::className(), ['fous_codusuario' => 'usu_codusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaoLocs()
    {
        return $this->hasMany(LocalizacaoLoc::className(), ['loc_codusuario' => 'usu_codusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuCodsituacao()
    {
        return $this->hasOne(SituacaosistemaSitsis::className(), ['sitsis_codsituacao' => 'usu_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuCodtipo()
    {
        return $this->hasOne(TipousuarioTipusu::className(), ['tipusu_codtipo' => 'usu_codtipo']);
    }
}
