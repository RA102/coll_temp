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
class MessageStatuses extends \yii\db\ActiveRecord
{
    const STATE_CREATED = 0; //заявка создана
    const STATE_RECEIVED = 1; //заявка получена
    const STATE_NOTIFICATED = 2; //заявка (IN_PROCESS) обрабатывается
    const STATE_SUCCESS = 3; //студент зачислен
    const STATE_REJECTED = 4; //заявка отклонена


   // add the function below:
    public static function getDb() {
        return Yii::$app->get('gospdb'); // gospdb database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messagestatuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['oid', 'status', 'sort'], 'default', 'value' => null],
            [['id', 'messagestatus'], 'integer'],
            
            [['statusts', 'status_body'], 'safe'],
            [['messageid', 'systemid'], 'string'] //, 'max' => 255],
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
            'messageid' => Yii::t('app', 'ИН сообщения'),
            'statusts' => Yii::t('app', 'Создано'),
            'systemid' => Yii::t('app', 'Система-обработчик'),
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
