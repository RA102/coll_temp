<?php

namespace common\models\gosp;

use Yii;
use yii\helpers\Json;

/**
 *
 * @property int $id

 * @property string $delete_ts
 * @property int $sort
 *
 
 */
class InputMessage extends \yii\db\ActiveRecord
{


   // add the function below:
    public static function getDb() {
        return Yii::$app->get('gospdb'); // gospdb database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inputmessages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['oid', 'status', 'sort'], 'default', 'value' => null],
            [['id', 'messagestatus', 'recstatus'], 'integer'],
            
            [['ts'], 'safe'],
            [['parsedmessage'], 'string'], //, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'messagestatus' => Yii::t('app', 'Статус сообщения'),
            'recstatus' => Yii::t('app', 'Статус записи'),
            'ts' => Yii::t('app', 'Создано'),
            'parsedmessage' => Yii::t('app', 'Сообщение'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    // public function afterFind()
    // {
    //     $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
    //     $this->caption_current = Json::decode($this->getAttribute('caption'))[$currentLanguage];

    //     parent::afterFind();
    // }
}
