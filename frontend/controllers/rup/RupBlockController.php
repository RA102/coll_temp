<?php

namespace frontend\controllers\rup;

use alhimik1986\PhpExcelTemplator\params\CallbackParam;
use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
use common\models\handbook\Speciality;
use common\models\rups\RupRoot;
use DateTime;
use frontend\models\rup\RupModule;
use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupSubjects;

use Yii;
use frontend\models\rup\RupBlock;
use frontend\models\rup\RupBlockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupBlockController implements the CRUD actions for RupBlock model.
 */
class RupBlockController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->enableCsrfValidation = false;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if ($action->id == 'createtemplate') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all RupBlock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RupBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RupBlock model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdateInfo($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $model->code = Yii::$app->request->post('code');
        $model->name = Yii::$app->request->post('name');
        $model->time = Yii::$app->request->post('time');
        if ($model->save()) {
            return "all good saved";
        } elseif (!$model->save) {
            return var_dump($model->errors);
        }
    }

    /**
     * Creates a new RupBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupBlock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model->id;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTest($rup_id)
    {
        $mainInfo=RupRoot::find()->where(['rup_id'=>$rup_id])->asArray()->all();
        $codeProfile=$mainInfo[0]['captionRu'];

        $codeSpecFind=Speciality::find()->where(['code'=>$mainInfo[0]['spec_code']])->one();
        $codeSpec=$codeSpecFind['caption']['ru'];

        $edu_form;

        $quals=RupQualifications::find()->where(['rup_id'=>$rup_id])->asArray()->all();

        if($mainInfo[0]['edu_form']==0){
            $edu_form="Очная";
        }
        else{$edu_form="Заочная";}
        $subjects=RupSubjects::find()->where(['rup_id'=>$rup_id])->asArray()->all();

        $rupBlocks=RupBlock::find()->where(['rup_id'=>$rup_id])->with('rupSubBlock')->asArray()->orderBy(['id'=>SORT_ASC])->all();



        $templateFile = 'templates/rup_test.xlsx';
        $fileName = './RUP_file.xlsx';
        $params = [
            '{codeProfile}' => $codeProfile,
            '{codeSpec}' => $codeSpec,
            '{qual1}'=>"1)".$quals[0]['qualification_code']."-".$quals[0]['qualification_name'],
            '{qual2}'=>"2)".$quals[1]['qualification_code']."-".$quals[1]['qualification_name'],
            '{formEducation}'=>"Форма обучения:".$edu_form,
            '{educationBase}'=>"на базе основного среднего образования",
            '{timeOfEducation}'=>
            'Нормативный срок обучения: '.$quals[0]['time_years'].'года '.$quals[0]['time_months'].' мес., '.
            $quals[1]['time_years'].' года '.$quals[1]['time_months'].' мес.',


        ];

        $callbacks = [
            '{codeProfile}' => function(CallbackParam $param) use ($quals,$rupBlocks,$subjects) {
                $F1=0;
                $sheet = $param->sheet;
                $cellA="A";
                $cellB="B";
                $cellC="C";
                $cellD="D";
                $cellE="E";
                $cellF="F";
                $cellG="G";
                $cellH="H";
                $cellI="I";
                $cellJ="J";
                $cellK="K";
                $cellL="L";
                $cellM="M";
                $cellN="N";
                $cellO="O";
                $cellP="P";
                $cellQ="Q";
                $cellR="R";
                $cellS="S";
                $cellT="T";
                $cellU="U";
                $G=0;
                $H=0;
                $I=0;
                $J=0;
                $K=0;
                $L=0;
                $M=0;
                $N=0;
                $O=0;
                $P=0;
                $Q=0;
                $R=0;
                $S=0;
                $T=0;
                $U=0;
                $G1=0;
                $H1=0;
                $I1=0;
                $J1=0;
                $K1=0;
                $L1=0;
                $M1=0;
                $N1=0;
                $O1=0;
                $P1=0;
                $Q1=0;
                $R1=0;
                $S1=0;
                $T1=0;
                $U1=0;
                $cell2=15;
                $cellAll=intval($cell2);
                $sheet->getStyle($cellA.$cell2)->getAlignment()->setWrapText(true);
                foreach ($rupBlocks as $b){
                    $F1=$F1+$b['time'];
                    $sheet->setCellValue($cellA.$cell2,$b['code']);
                    $sheet->setCellValue($cellB.$cell2,$b['name']);
                    $sheet->setCellValue($cellF.$cell2,$b['time']);
                    $sheet->getStyle($cellA.$cell2.":".$cellU.$cell2)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('538DD5');
                    $sheet->getStyle($cellA.$cell2.":".$cellU.$cell2)->getFont()->setBold( true );

                    $cell2++;
                    foreach ($b['rupSubBlock'] as $a){
                        $sheet->setCellValue($cellA.$cell2,$a['code']);
                        $sheet->setCellValue($cellB.$cell2,$a['name']);
                        $sheet->getStyle("L".$cell2)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('B7DEE8');
                        $sheet->getStyle("O".$cell2)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('B7DEE8');
                        $sheet->getStyle("R".$cell2)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('B7DEE8');
                        $sheet->getStyle("U".$cell2)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('B7DEE8');
                        $cell2++;
                        $subBlockId=$a['id'];
                        foreach ($subjects as $s){
                            if($s['id_sub_block']==$subBlockId){
                                $sheet->setCellValue($cellA.$cell2,$s['code']);
                                $sheet->setCellValue($cellB.$cell2,$s['name']);
                                $sheet->setCellValue($cellC.$cell2,$s['exam']);
                                $sheet->setCellValue($cellD.$cell2,$s['offset']);
                                $sheet->setCellValue($cellE.$cell2,$s['control_work']);
                                $sheet->setCellValue($cellF.$cell2,$s['time']);
                                $sheet->setCellValue($cellG.$cell2,$s['teory_time']);
                                $G=$G+$s['teory_time'];
                                $G1=$G1+$s['teory_time'];
                                $sheet->setCellValue($cellH.$cell2,$s['lab_time']);
                                $H=$H+$s['lab_time'];
                                $H1=$H1+$s['lab_time'];
                                $sheet->setCellValue($cellI.$cell2,$s['production_practice_time']);
                                $I=$I+$s['production_practice_time'];
                                $I1=$I1+$s['production_practice_time'];
                                $sheet->setCellValue($cellJ.$cell2,$s['one_sem_time']);
                                $J=$J+$s['one_sem_time'];
                                $J1=$J1+$s['one_sem_time'];
                                $sheet->setCellValue($cellK.$cell2,$s['two_sem_time']);
                                $K=$K+$s['two_sem_time'];
                                $K1=$K1+$s['two_sem_time'];
                                $sheet->setCellValue($cellL.$cell2,$s['one_sem_time']+$s['two_sem_time']);
                                $L=$L+($s['one_sem_time']+$s['two_sem_time']);
                                $L1=$L1+($s['one_sem_time']+$s['two_sem_time']);
                                $sheet->setCellValue($cellM.$cell2,$s['three_sem_time']);
                                $M=$M+$s['three_sem_time'];
                                $M1=$M1+$s['three_sem_time'];
                                $sheet->setCellValue($cellN.$cell2,$s['four_sem_time']);
                                $N=$N+$s['four_sem_time'];
                                $N1=$N1+$s['four_sem_time'];
                                $sheet->setCellValue($cellO.$cell2,$s['three_sem_time']+$s['four_sem_time']);
                                $O=$O+$s['three_sem_time']+$s['four_sem_time'];
                                $O1=$O1+$s['three_sem_time']+$s['four_sem_time'];
                                $sheet->setCellValue($cellP.$cell2,$s['five_sem_time']);
                                $P=$P+$s['five_sem_time'];
                                $P1=$P1+$s['five_sem_time'];
                                $sheet->setCellValue($cellQ.$cell2,$s['six_sem_time']);
                                $Q=$Q+$s['six_sem_time'];
                                $Q1=$Q1+$s['six_sem_time'];
                                $sheet->setCellValue($cellR.$cell2,$s['five_sem_time']+$s['six_sem_time']);
                                $R=$R+$s['five_sem_time']+$s['six_sem_time'];
                                $R1=$R1+$s['five_sem_time']+$s['six_sem_time'];
                                $sheet->setCellValue($cellS.$cell2,$s['seven_sem_time']);
                                $S=$S+$s['seven_sem_time'];
                                $S1=$S1+$s['seven_sem_time'];
                                $sheet->setCellValue($cellT.$cell2,$s['eight_sem_time']);
                                $T=$T+$s['eight_sem_time'];
                                $T1=$T1+$s['eight_sem_time'];
                                $sheet->setCellValue($cellU.$cell2,$s['seven_sem_time']+$s['eight_sem_time']);
                                $U=$U+$s['seven_sem_time']+$s['eight_sem_time'];
                                $U1=$U1+$s['seven_sem_time']+$s['eight_sem_time'];
                                $sheet->getStyle("L".$cell2)->getFont()->setBold( true );
                                $sheet->getStyle("O".$cell2)->getFont()->setBold( true );
                                $sheet->getStyle("R".$cell2)->getFont()->setBold( true );
                                $sheet->getStyle("U".$cell2)->getFont()->setBold( true );
                                $sheet->getStyle("L".$cell2)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('B7DEE8');
                                $sheet->getStyle("O".$cell2)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('B7DEE8');
                                $sheet->getStyle("R".$cell2)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('B7DEE8');
                                $sheet->getStyle("U".$cell2)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('B7DEE8');
                                $cell2++;
                            }
                        }
                    }
                    $sheet->setCellValue($cellG.$cellAll,$G);
                    $sheet->setCellValue($cellH.$cellAll,$H);
                    $sheet->setCellValue($cellI.$cellAll,$I);
                    $sheet->setCellValue($cellJ.$cellAll,$J);
                    $sheet->setCellValue($cellK.$cellAll,$K);
                    $sheet->setCellValue($cellL.$cellAll,$L);
                    $sheet->setCellValue($cellM.$cellAll,$M);
                    $sheet->setCellValue($cellN.$cellAll,$N);
                    $sheet->setCellValue($cellO.$cellAll,$O);
                    $sheet->setCellValue($cellP.$cellAll,$P);
                    $sheet->setCellValue($cellQ.$cellAll,$Q);
                    $sheet->setCellValue($cellR.$cellAll,$R);
                    $sheet->setCellValue($cellS.$cellAll,$S);
                    $sheet->setCellValue($cellT.$cellAll,$T);
                    $sheet->setCellValue($cellU.$cellAll,$U);
                    $G=0;
                    $H=0;
                    $I=0;
                    $J=0;
                    $K=0;
                    $L=0;
                    $M=0;
                    $N=0;
                    $O=0;
                    $P=0;
                    $Q=0;
                    $R=0;
                    $S=0;
                    $T=0;
                    $U=0;
                    $cellAll=intval($cell2);

                }
//
                $sheet->setCellValue($cellB.$cell2,"Итого:");
                $sheet->setCellValue($cellG.$cell2,$G1);
                $sheet->setCellValue($cellH.$cell2,$H1);
                $sheet->setCellValue($cellI.$cell2,$I1);
                $sheet->setCellValue($cellJ.$cell2,$J1);
                $sheet->setCellValue($cellK.$cell2,$K1);
                $sheet->setCellValue($cellL.$cell2,$L1);
                $sheet->setCellValue($cellM.$cell2,$M1);
                $sheet->setCellValue($cellN.$cell2,$N1);
                $sheet->setCellValue($cellO.$cell2,$O1);
                $sheet->setCellValue($cellP.$cell2,$P1);
                $sheet->setCellValue($cellQ.$cell2,$Q1);
                $sheet->setCellValue($cellR.$cell2,$R1);
                $sheet->setCellValue($cellS.$cell2,$S1);
                $sheet->setCellValue($cellT.$cell2,$T1);
                $sheet->setCellValue($cellU.$cell2,$U1);
                $sheet->setCellValue($cellF.$cell2,$F1);
                $sheet->getStyle($cellA.$cell2.":".$cellU.$cell2)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->getStyle($cellA.$cell2.":".$cellU.$cell2)->getFont()->setBold( true );
            }
        ];


        PhpExcelTemplator::outputToFile($templateFile, $fileName, $params, $callbacks);
// PhpExcelTemplator::outputToFile($templateFile, $fileName, $params); // to download the file from web page

    }

    public function actionCreatetemplate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $block_id = "asg";
        $id = Yii::$app->request->post('isTemplate');
        if (Yii::$app->request->isPost) {
            $code = Yii::$app->request->post('code');
            $rup_id = Yii::$app->request->post('rup_id');
            $name = Yii::$app->request->post('name');
            $modelTemplate = RupBlock::find()->where(['id' => $id])->asArray()->limit(1)->all();
            $model = new RupBlock();
            $model->time = $modelTemplate[0]['time'];
            $model->code = $code;
            $model->rup_id = $rup_id;
            $model->name = $name;
            $model->isTemplate = false;
            $model->save(false);
            $block_id = $model->id;
        }


        $modules = RupModule::find()->where(['block_id' => $id])->asArray()->all();
        foreach ($modules as $module) {
            $rup_module = New RupModule();
            $rup_module->rup_id = Yii::$app->request->post('rup_id');
            $rup_module->code = $module['code'];
            $rup_module->name = $module['name'];
            $rup_module->time = $module['time'];
            $rup_module->block_id = $model->id;
            $rup_module->save(false);

            $rupSubjects = RupSubjects::find()->
            where(['id_sub_block' => $module['id']])->asArray()
                ->all();
            foreach ($rupSubjects as $rup_subject) {
                $rupSubjects = New RupSubjects();
                $rupSubjects->rup_id = Yii::$app->request->post('rup_id');
                $rupSubjects->id_sub_block = $rup_module->id;
                $rupSubjects->id_block = $block_id;
                $rupSubjects->exam = $rup_subject['exam'];
                $rupSubjects->control_work = $rup_subject['control_work'];
                $rupSubjects->offset = $rup_subject['offset'];
                $rupSubjects->time = $rup_subject['time'];
                $rupSubjects->teory_time = $rup_subject['teory_time'];
                $rupSubjects->lab_time = $rup_subject['lab_time'];
                $rupSubjects->production_practice_time = $rup_subject['production_practice_time'];
                $rupSubjects->one_sem_time = $rup_subject['one_sem_time'];
                $rupSubjects->two_sem_time = $rup_subject['two_sem_time'];
                $rupSubjects->three_sem_time = $rup_subject['three_sem_time'];
                $rupSubjects->four_sem_time = $rup_subject['four_sem_time'];
                $rupSubjects->five_sem_time = $rup_subject['five_sem_time'];
                $rupSubjects->six_sem_time = $rup_subject['six_sem_time'];
                $rupSubjects->seven_sem_time = $rup_subject['seven_sem_time'];
                $rupSubjects->eight_sem_time = $rup_subject['eight_sem_time'];
                $rupSubjects->name = $rup_subject['name'];
                $rupSubjects->code = $rup_subject['code'];
                $rupSubjects->save(false);
            }
        }
        return $rupSubjects;
    }

    /**
     * Updates an existing RupBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RupBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteAjax($id)
    {
        $model = $this->findModel($id);
        $model->rup_id = 0;
        if ($model->save()) {
            return "ok";
        };
    }

    /**
     * Finds the RupBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
