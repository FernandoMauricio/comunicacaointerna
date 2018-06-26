<?php

namespace app\models;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * This is the model class for table "anexocomunicacao_ane".
 *
 * @property string $ane_codanexo
 * @property string $ane_codcomunicacao
 * @property string $ane_arquivo
 *
 * @property ComunicacaointernaCom $aneCodcomunicacao
 */
class AnexocomunicacaoAne extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anexocomunicacao_ane';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ane_codcomunicacao', 'ane_arquivo'], 'required'],
            [['ane_codcomunicacao'], 'integer'],
            [['ane_arquivo'], 'string', 'max' => 80],
            [['ane_arquivo'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ane_codanexo' => 'Código',
            'ane_codcomunicacao' => 'Anexo',
            'ane_arquivo' => 'Arquivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAneCodcomunicacao()
    {
        return $this->hasOne(ComunicacaointernaCom::className(), ['com_codcomunicacao' => 'ane_codcomunicacao']);
    }
}
