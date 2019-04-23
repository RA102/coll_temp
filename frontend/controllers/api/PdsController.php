<?php

namespace frontend\controllers\api;

use common\models\person\PersonType;
use common\models\system\Setting;
use common\services\system\PdsService;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

/**
 * PDS controller
 */
class PdsController extends ActiveController
{
    use OptionsTrait;

    public $modelClass = 'common\models\system\Setting';
    private $pdsService;

    public function __construct(
        string $id,
        $module,
        PdsService $pdsService,
        array $config = []
    )
    {
        $this->pdsService = $pdsService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->getOptionsHeaders();
        \Yii::$app->request->parsers = ['application/json' => 'yii\web\JsonParser'];

        return parent::beforeAction($action);
    }

    /**
     * Update pds token
     * @throws ServerErrorHttpException
     */
    public function actionSetAccessToken()
    {
        $pds_token = \Yii::$app->request->post(Setting::PDS_TOKEN_NAME);
        if (!$pds_token) {
            throw new ServerErrorHttpException('No token received');
        }

        if (!$this->pdsService->saveToken($pds_token)) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetRoles()
    {
        return [
            [
                "name" => "chairman",
                "caption" => [
                    "kk" => "Комиссия төрағасы",
                    "ru" => "Председатель комиссии"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "guest",
                "caption" => [
                    "kk" => "Қонақ",
                    "ru" => "Гость"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "teacher",
                "caption" => [
                    "kk" => "Оқытушы",
                    "ru" => "Преподаватель"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "pupil",
                "caption" => [
                    "kk" => "Оқушы",
                    "ru" => "Ученик"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "parent",
                "caption" => [
                    "kk" => "Ата-аналар",
                    "ru" => "Родители"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "director",
                "caption" => [
                    "kk" => "Директор",
                    "ru" => "Директор"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "staff",
                "caption" => [
                    "kk" => "Қызметкер",
                    "ru" => "Персонал"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "personnel department",
                "caption" => [
                    "kk" => "Кадр бөлімі",
                    "ru" => "Отдел кадров"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "translator",
                "caption" => [
                    "kk" => "Аудармашы",
                    "ru" => "Переводчик"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "methodist",
                "caption" => [
                    "kk" => "Әдіскер",
                    "ru" => "Методист"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "librarian",
                "caption" => [
                    "kk" => "Кітапханашы",
                    "ru" => "Библиотекарь"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "zavhoz",
                "caption" => [
                    "kk" => "Шаруашылық бөлімін меңгеруші",
                    "ru" => "Заведующий хоз. частью"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "secretary",
                "caption" => [
                    "kk" => "Оқу бөлімінің хатшысы",
                    "ru" => "Секретарь УЧ"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "edirector",
                "caption" => [
                    "kk" => "Оқу тәрбиелік жұмысы бойынша директордың орынбасары",
                    "ru" => "Зам. директора по УВР"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "psychologist",
                "caption" => [
                    "kk" => "Психолог",
                    "ru" => "Психолог"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "accountant",
                "caption" => [
                    "kk" => "Бухгалтер",
                    "ru" => "Бухгалтер"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "medical_worker",
                "caption" => [
                    "kk" => "Медицина қызметкері",
                    "ru" => "Медицинский работник"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "cabinet_educator",
                "caption" => [
                    "kk" => "Тәрбиеші",
                    "ru" => "Воспитатель"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "goroo",
                "caption" => [
                    "kk" => "Қалалық білім бөлімінің қызметкері",
                    "ru" => "Сотрудник ГорОО"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "student",
                "caption" => [
                    "kk" => "Студент",
                    "ru" => "Студент"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "entrant",
                "caption" => [
                    "kk" => "Өтініш беруші",
                    "ru" => "Абитуриент"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "alledu",
                "caption" => [
                    "ru" => "Всеобуч"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "master",
                "caption" => [
                    "kk" => "Мастер",
                    "ru" => "Мастер"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "super_puper_admin",
                "caption" => [
                    "en" => "Global administrator",
                    "kk" => "Жаһандық әкімші",
                    "ru" => "Глобальный администратор"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "director_upr",
                "caption" => [
                    "kk" => "ОӨЖ бойынша директордың орынбасары",
                    "ru" => "Зам. директора по УПР"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "commission_secretary",
                "caption" => [
                    "kk" => "Комиссия хатшысы",
                    "ru" => "Секретарь комиссии"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "member",
                "caption" => [
                    "kk" => "Комиссия мүшесі",
                    "ru" => "Член комиссии"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "vicechairman",
                "caption" => [
                    "kk" => "Комиссия төрағасының орынбасары",
                    "ru" => "Заместитель председателя комиссии"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "deply_director",
                "caption" => [
                    "kk" => "Оқу-ісі жөніндегі директордың орынбасары",
                    "ru" => "Зам. директора по УР"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "zam-direktora-po-po",
                "caption" => [
                    "kk" => "",
                    "ru" => "Зам. Директора по ПО"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "commissions",
                "caption" => [
                    "kk" => null,
                    "ru" => "Член комиссии"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "superadmin",
                "caption" => [
                    "kk" => "Жүйе әкімшісі",
                    "ru" => "Супер администратор"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "social_teacher",
                "caption" => [
                    "kk" => "Социальный педагог",
                    "ru" => "Социальный педагог"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "Laborant",
                "caption" => [
                    "kk" => null,
                    "ru" => "Лаборант"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "alledu.add",
                "caption" => [
                    "kk" => null,
                    "ru" => "alledu.add"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "educator",
                "caption" => [
                    "kk" => "Тәрбиеші",
                    "ru" => "Воспитатель"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "Психолог",
                "caption" => [
                    "kk" => null,
                    "ru" => "Педагог-психолог"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "Делопроизводитель ",
                "caption" => [
                    "kk" => "Іс-жүргізуші",
                    "ru" => "Делопроизводитель "
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "Library",
                "caption" => [
                    "kk" => null,
                    "ru" => "кабинет библиотекаря"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "Social pedagog",
                "caption" => [
                    "kk" => "Әлеуметтік педагог",
                    "ru" => "Социальный педагог"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "social_pedagogy",
                "caption" => [
                    "kk" => null,
                    "ru" => "социального педагога"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "logoped",
                "caption" => [
                    "kk" => null,
                    "ru" => "Логопед"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "biblioteka",
                "caption" => [
                    "kk" => null,
                    "ru" => "Библиотека"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "postman",
                "caption" => [
                    "kk" => null,
                    "ru" => "Канцелярия"
                ],
                "parent_id" => 0,
                "action" => null
            ],
            [
                "name" => "selection_comitet",
                "caption" => [
                    "kk" => null,
                    "ru" => "Приёмная комиссия"
                ],
                "parent_id" => 0,
                "action" => null
            ]
        ];
    }

    /**
     * @return array
     */
    public function actionGetRoutes()
    {
        $result = [['name' => '/.*/']];
        return $result;
    }
}
