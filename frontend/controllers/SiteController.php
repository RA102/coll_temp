<?php

namespace frontend\controllers;

use common\forms\auth\LoginForm;
use common\services\organization\InstitutionApplicationService;
use common\services\pds\LoginService;
use common\services\pds\PersonService;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
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
class SiteController extends Controller
{
    private $loginService;
    private $applicationService;
    private $pdsPersonService;

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
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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

    public function __construct(
        string $id,
        Module $module,
        LoginService $loginService,
        InstitutionApplicationService $applicationService,
        PersonService $personService,
        array $config = []
    ) {
        $this->loginService = $loginService;
        $this->applicationService = $applicationService;
        $this->pdsPersonService = $personService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm($this->loginService);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'main-login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->applicationService->create($model);
            return $this->renderAjax('_signup_success');
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'main-login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->pdsPersonService->resetPassword($model->email);
                Yii::$app->session->setFlash('success', 'Проверьте свою email-почту для дальнейших инструкций');
                return $this->goHome();
            } catch (\Exception $e) {
                if (Yii::$app->request->get('debug')) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                } else {
                    Yii::$app->session->setFlash('error',
                        'Извините, для указанного email-адреса процедура невозможна');
                }
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'main-login';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->pdsPersonService->changePassword($token, $model->password, $model->repassword);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен');
                return $this->goHome();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage() ); //. " : " . $e->getTraceAsString());
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
