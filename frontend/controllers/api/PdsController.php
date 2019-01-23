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

        return parent::beforeAction($action);
    }

    /**
     * Update pds token
     * @throws ServerErrorHttpException
     */
    public function actionSetAccessToken()
    {
        $pds_token = \Yii::$app->request->post(Setting::PDS_TOKEN_NAME);
        $post = file_get_contents('php://input');
        $request = [
            \Yii::$app->request->getMethod(),
            \Yii::$app->request->getHeaders(),
            \Yii::$app->request->getAbsoluteUrl(),
            \Yii::$app->request->getQueryParams(),
            \Yii::$app->request->getBodyParams(),
            $post
        ];
        throw new ServerErrorHttpException(json_encode($request));
        if (!$pds_token) {
            throw new ServerErrorHttpException('No token received');
        }

        if (!$this->pdsService->saveToken($pds_token)) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return true;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetRoles()
    {
        return PersonType::find()->all();
    }

    /**
     * @return array
     */
    public function actionGetRoutes()
    {
        $result = [];
        return $result;
    }
}
