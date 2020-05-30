<?php

namespace frontend\controllers\gos;

// use common\forms\auth\LoginForm;
// use common\services\organization\InstitutionApplicationService;
// use common\services\pds\LoginService;
// use common\services\pds\PersonService;
// use frontend\models\PasswordResetRequestForm;
// use frontend\models\ResetPasswordForm;
// use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class InviteController extends Controller
{
    // private $loginService;
    // private $applicationService;
    // private $pdsPersonService;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'index'],
                'rules' => [
                    [
                        //'actions' => ['logout', 'index'],
                        'allow'   => true,
                        //'roles'   => ['@'],
                    ],
                ],
            ],
            // 'verbs'  => [
            //     'class'   => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // public function __construct(
    //     string $id,
    //     Module $module,
    //     //LoginService $loginService,
    //     //InstitutionApplicationService $applicationService,
    //     //PersonService $personService,
    //     array $config = []
    // ) {
    //     //$this->loginService = $loginService;
    //     //$this->applicationService = $applicationService;
    //     //$this->pdsPersonService = $personService;
    //     parent::__construct($id, $module, $config);
    // }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = false;
        return $this->render('index');
    }

   

}
