<?php

namespace api\modules\v1\controllers;

use common\behaviours\PdsBearerAuth;
use common\models\organization\Institution;
use common\services\organization\GroupService;
use common\services\person\StudentService;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\base\Module;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    protected $groupService;
    protected $studentService;
    /** @var Institution */
    protected $institution;

    public function __construct(
        string $id,
        Module $module,
        GroupService $groupService,
        StudentService $studentService,
        array $config = []
    ) {
        $this->groupService = $groupService;
        $this->studentService = $studentService;

        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['cors'] = [
            'class' => Cors::class,
            'actions' => [
                self::actionGroups => ['Access-Control-Request-Method' => ['GET']],
                self::actionStudents => ['Access-Control-Request-Method' => ['GET']],
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                self::actionGroups => ['GET'],
                self::actionStudents => ['GET'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => PdsBearerAuth::class,
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        $result = parent::beforeAction($action);

        $this->institution = \Yii::$app->user->identity->institution;

        return $result;
    }

    const actionGroups = 'groups';
    public function actionGroups()
    {
        return $this->groupService->getGroups($this->institution);
    }

    const actionStudents = 'students';
    public function actionStudents($group_id)
    {
        $group = $this->findGroup($this->institution, $group_id);
        return $this->studentService->getGroupStudents($group);
    }

    protected function findGroup(Institution $institution, $id)
    {
        $group = $this->groupService->getGroup($institution, $id);
        if ($group !== null) {
            return $group;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
