<?php

namespace common\models\reception;


use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "reception.admission_application".
 *
 * @property int $id

 */
class AdmissionFiles extends \yii\db\ActiveRecord
{
    const DOC_TYPE_PHOTO = "person_photo";

    private $is_new = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.admission_files';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aa_id', 'person_id', 'state'], 'integer'],
            [['doc_type', 'url', 'file_meta', 'state'], 'required'],
            [['file_meta','rec_add_ts'], 'safe'],
            [['doc_type'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 400]
           
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    // public function beforeSave($insert)
    // {
    //     if (!parent::beforeSave($insert)) {
    //         return false;
    //     }

    //     if ($insert || $this->isAttributeChanged('status')) {
    //         if (!$this->history) {
    //             $this->history = [];
    //         }

    //         $this->history = array_merge($this->history, [
    //             [
    //                 'status' => $this->status,
    //                 'date'   => date("Y-m-d H:i:s")
    //             ]
    //         ]);
    //     }

    //     return true;
    // }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'aa_id'          => Yii::t('app', 'Заявление'),
            'person_id'      => Yii::t('app', 'ФЛ'),
            'doc_type'       => Yii::t('app', 'Тип документа'),
            'file_meta'      => Yii::t('app', 'Метаданные'),
            'url'            => Yii::t('app', 'Ссылка'),
            'state'          => Yii::t('app', 'Состояние'), //0-норма, 1-удалено
            'rec_add_ts'     => Yii::t('app', 'Добавлена')
        ];
    }

    /**

     */
    public static function add(String $doc_type, String $file_meta, String $url, int $aa_id = null, int $person_id = null)
    {
        $model = AdmissionFiles::find()->where(['doc_type' => $doc_type, 'url' => $url])->one();
        if ($model == null){
            $model = new self();
            $model->is_new = true;
        } 

        $model->aa_id = $aa_id;
        $model->person_id = $person_id;
        $model->doc_type = $doc_type;
        $model->file_meta = $file_meta;
        $model->url = $url;
        $model->state = 0;
        return $model;
    }    

    public function getIsNew(){
        return $this->is_new;
    }

    public function getDocTypeLabel(){
        $label = "Не определен";
        switch ($this->doc_type) {
            case $this::DOC_TYPE_PHOTO:
                $label = "Личное фото";
                break;

            default:
            $label = "Не определен";
        };
        return $label;
    }

    /**
     *
     */
    // public function afterFind()
    // {
    //     parent::afterFind();
    //     if (!$this->person_id) {
    //         $entrant = Entrant::add(
    //             null,
    //             $this->properties['firstname'],
    //             $this->properties['lastname'],
    //             $this->properties['middlename'],
    //             $this->properties['iin']
    //         );
    //         $entrant->setAttributes(($this->properties));
    //         $this->populateRelation('person', $entrant);
    //     }
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        //if ($this->isEnlisted()) {
            return $this->hasOne(Person::class, ['id' => 'person_id']);
        //}
        //return $this->hasOne(Entrant::class, ['id' => 'person_id']);
    }

   

   
}
