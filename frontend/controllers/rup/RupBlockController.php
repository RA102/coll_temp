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

    public function actionOnetest()
    {
//        $templateFile = './template.xlsx';
        $fileName = './exported_file.xlsx';
//        $params = [
//            '{ruproots-captionru}'=>'RUP RU NAME',
//            '{ruproots-profile_code}'=>'CODE',
//            '[qualifications]'=>[1,2],
//            '{study_form}'=>'StudyForm',
//            '{study_years}'=>'StudySrok',
//            '{base}'=>'On base of education'
//        ];
////        return PhpExcelTemplator::saveToFile($templateFile, $fileName, $params);
//         PhpExcelTemplator::saveToFile($templateFile, $fileName, $params); // to download the file from web page
//        return $fileName;
        $bg = array(

            'fill' => array(

                'type' => PHPExcel_Style_Fill::FILL_SOLID,

                'color' => array('rgb' => '01B050')

            )

        );
        $border = array(

            'borders' => array(

                'outline' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

                    'color' => array('rgb' => '000000')

                ),

            )

        );


        $xls = new \PHPExcel();
        $xls->getProperties()->setTitle("Название");
        $xls->getProperties()->setSubject("Тема");
        $xls->getProperties()->setCreator("Автор");
        $xls->getProperties()->setManager("Руководитель");
        $xls->getProperties()->setCompany("Организация");
        $xls->getProperties()->setCategory("Группа");
        $xls->getProperties()->setKeywords("Ключевые слова");
        $xls->getProperties()->setDescription("Примечания");
        $xls->getProperties()->setLastModifiedBy("Автор изменений");
        $xls->getProperties()->setCreated("25.03.2019");

        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('РУП');

        $sheet->setCellValue("G1", "ПЛАН УЧЕБНОГО ПРОЦЕССА");
        $sheet->setCellValue("A3", "Код и профиль образования:");
        $sheet->setCellValue("D3", "{ruproots-captionru}");
        $sheet->setCellValue("A4", "Специальность:");
        $sheet->setCellValue("D4", "{ruproots-profile_code}");
        $sheet->setCellValue("A5", "Квалификация:");
        $sheet->setCellValue("D5", "[qualifications]");
        $sheet->setCellValue("K7", "{study_form}");
        $sheet->setCellValue("K8", "{study_years}");
        $sheet->setCellValue("K9", "на базе основного среднего образования");
        $sheet->getStyle("B11")->applyFromArray($border);
        $sheet->getStyle("A11")->applyFromArray($border);
        $sheet->getStyle("B11")->applyFromArray($border);
        $sheet->getStyle("C11")->applyFromArray($border);
        $sheet->getStyle("F11")->applyFromArray($border);
        $sheet->getStyle("G11")->applyFromArray($bg);
        $sheet->getStyle("A11")->applyFromArray($bg);
        $sheet->setCellValue("A11", "индекс");
        $sheet->mergeCells("A11:A13");
        $sheet->mergeCells("B11:B13");
        $sheet->mergeCells("C11:E11");
        $sheet->mergeCells("F11:I11");
        $sheet->mergeCells("G11:U11");
        $sheet->getRowDimension("12")->setRowHeight(50);
        $sheet->getRowDimension("13")->setRowHeight(50);
        $sheet->getColumnDimension("B")->setWidth(30);
        $objWriter = new PHPExcel_Writer_Excel2007($xls);

        $objWriter->save($fileName);


        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true); //optional

        $objPHPExcel = $objReader->load('exported_file.xlsx');
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $i = 1;
        foreach ($objWorksheet->getRowIterator() as $row) {
            if ($column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getValue() == "Значение") {
//                echo $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getValue()."\r";

                echo $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getCoordinate();//column A
            }
            if ($column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getValue() == "[coll]") {
//                echo $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getValue()."\r";

                echo $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("E$i")->getCoordinate();//column A
            }

            //you can add your own columns B, C, D etc.

            //inset $column_A_Value value in DB query here

            $i++;
        }
//        return var_dump($objPHPExcel);


    }

    public function actionTwotest()
    {
        function makeHeader(){
            $catList = [
                ['name' => 'Tom', 'color' => 'red'],
                ['name' => 'Bars', 'color' => 'white'],
                ['name' => 'Jane', 'color' => 'Yellow'],
            ];

            $document = new \PHPExcel();

            $sheet = $document->setActiveSheetIndex(0); // Выбираем первый лист в документе

            $columnPosition = 0; // Начальная координата x
            $startLine = 2; // Начальная координата y

// Вставляем заголовок в "A2"
            $sheet->setCellValueByColumnAndRow($columnPosition, $startLine, 'Our cats');

// Выравниваем по центру
            $sheet->getStyleByColumnAndRow($columnPosition, $startLine)->getAlignment()->setHorizontal(
                PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow($columnPosition,$startLine)->getAlignment()->setTextRotation(90);

// Объединяем ячейки "A2:C2"
            $document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine, $columnPosition+2, $startLine);
//        $document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine-1, $columnPosition+2, $startLine);

// Перекидываем указатель на следующую строку
            $startLine++;

// Массив с названиями столбцов
            $columns = ['№', 'Name', 'Color'];

// Указатель на первый столбец
            $currentColumn = $columnPosition;

// Формируем шапку
            foreach ($columns as $column) {
                // Красим ячейку
                $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
                    ->getFill()
                    ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('4dbf62');

                $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $column);

                // Смещаемся вправо
                $currentColumn++;
            }

// Формируем список
            foreach ($catList as $key=>$catItem) {
                // Перекидываем указатель на следующую строку
                $startLine++;
                // Указатель на первый столбец
                $currentColumn = $columnPosition;
                // Вставляем порядковый номер
                $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $key+1);

                // Ставляем информацию об имени и цвете
                foreach ($catItem as $value) {
                    $currentColumn++;
                    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $value);
                }
            }

            $objWriter = \PHPExcel_IOFactory::createWriter($document, 'Excel5');
            $objWriter->save("CatList.xls");
        }
        makeHeader();
        makeHeader();

//
//        $templateFile = './mplate.xlsx';
//        $fileName = './exported_file.xlsx';
//
//        $params = [
//            '{ruproots-captionru}' => 'RUP RU NAME',
//            '{ruproots-profile_code}' => 'CODE',
////            '[qualifications]'=>[1,2],
//            '{study_form}' => 'StudyForm',
//            '{study_years}' => 'StudySrok',
//            '{base}' => 'On base of education'
//        ];
//        PhpExcelTemplator::saveToFile($templateFile, $fileName, $params);
// PhpExcelTemplator::outputToFile($templateFile, $fileName, $params); // to download the file from web page

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



        $templateFile = './rup_test.xlsx';
        $fileName = './exported_file.xlsx';
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
                $cell2=15;
                $sheet->getStyle($cellA.$cell2)->getAlignment()->setWrapText(true);
                foreach ($rupBlocks as $b){
                    $sheet->setCellValue($cellA.$cell2,$b['code']);
                    $sheet->setCellValue($cellB.$cell2,$b['name']);
                    $sheet->setCellValue($cellF.$cell2,$b['time']);
                    $sheet->getStyle($cellA.$cell2.":".$cellU.$cell2)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('538DD5');

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
                                $sheet->setCellValue($cellH.$cell2,$s['lab_time']);
                                $sheet->setCellValue($cellI.$cell2,$s['production_practice_time']);
                                $sheet->setCellValue($cellJ.$cell2,$s['one_sem_time']);
                                $sheet->setCellValue($cellK.$cell2,$s['two_sem_time']);
                                $sheet->setCellValue($cellL.$cell2,$s['one_sem_time']+$s['two_sem_time']);
                                $sheet->setCellValue($cellM.$cell2,$s['three_sem_time']);
                                $sheet->setCellValue($cellN.$cell2,$s['four_sem_time']);
                                $sheet->setCellValue($cellO.$cell2,$s['three_sem_time']+$s['four_sem_time']);
                                $sheet->setCellValue($cellP.$cell2,$s['five_sem_time']);
                                $sheet->setCellValue($cellQ.$cell2,$s['six_sem_time']);
                                $sheet->setCellValue($cellR.$cell2,$s['five_sem_time']+$s['six_sem_time']);
                                $sheet->setCellValue($cellS.$cell2,$s['seven_sem_time']);
                                $sheet->setCellValue($cellT.$cell2,$s['eight_sem_time']);
                                $sheet->setCellValue($cellU.$cell2,$s['seven_sem_time']+$s['eight_sem_time']);
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
                }
//                $sheet->mergeCells("A17:A21");

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
