<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\workload\WorkloadDiscipline;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\workload\WorkloadDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model frontend\models\workload\WorkloadTeacher */

$this->title = 'Нагрузка по группам';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
      <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <body class="hold-transition skin-black-light sidebar-mini">

    <?php $this->beginBody() ?>




<div id="app">
    <!-- Фильтры -->
    <div class="card-body skin-white">
        <div class="row" style="margin-top: 2px;" >
            <div class="col-md-1" style="padding: 8px;"> Кафедра
            </div>
            <div class="col-md-5"  >
                <el-select v-model="filter_department" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in departments"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" style="padding: 8px;"> Форма обучения
            </div>
            <div class="col-md-4"  >
                <el-select v-model="filter_eduform" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in eduforms"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" style="padding: 8px;"> Группа
            </div>
            <div class="col-md-5"  >
                <el-select v-model="filter_studentgroup" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in studentgroups"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" style="padding: 8px;"> Язык обучения
            </div>
            <div class="col-md-4"  >
                <el-select v-model="filter_edulang" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in edulangs"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" style="padding: 8px;"> Дисциплина
            </div>
            <div class="col-md-5"  >
                <el-select v-model="filter_discipline" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in disciplines"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" style="padding: 8px;"> Курс
            </div>
            <div class="col-md-4"  >
                <el-select v-model="filter_course" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in courselist"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" style="padding: 8px;"> Год
            </div>
            <div class="col-md-1"  >
                <el-select v-model="filter_year"  style="width: 100%;" >
                    <el-option
                    v-for="item in yearlist"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-1" style="padding: 8px;"> РУП
            </div>
            <div class="col-md-3"  >
                <el-select v-model="filter_rup" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in rups"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-4" >
            </div>
            <div class="col-md-1"  >
                <el-button type="primary" icon="el-icon-search" round>Обновить</el-button>
            </div>
        </div>




    </div>
    <div>&nbsp;
    </div>
    <!-- Таблица -->
    <div class="card-body skin-white">
        <template>
        <el-table
            :data="tableData"
            style="width: 100%">
            <el-table-column type="expand">
                <template slot-scope="props">
                    <p>State: {{ props.row.state }}</p>
                    <p>City: {{ props.row.city }}</p>
                    <p>Address: {{ props.row.address }}</p>
                    <p>Zip: {{ props.row.zip }}</p>
                </template>
            </el-table-column>
            <el-table-column
                label="Индекс"
                prop="date">
            </el-table-column>
            <el-table-column
                label="Дисциплина"
                prop="name">
            </el-table-column>
            <el-table-column label="Объем учебного времени">
                <el-table-column
                    label="Всего"
                    prop="htotal">
                </el-table-column>
                <el-table-column
                    label="1 сем."
                    prop="hsem1">
                </el-table-column>
                <el-table-column
                    label="теор."
                    prop="hteor1">
                </el-table-column>
                <el-table-column
                    label="прак., лаб."
                    prop="hprakt1">
                </el-table-column>
                <el-table-column
                    label="2 сем."
                    prop="hsem2">
                </el-table-column>
                <el-table-column
                    label="теор."
                    prop="hteor2">
                </el-table-column>
                <el-table-column
                    label="прак., лаб."
                    prop="hprakt2">
                </el-table-column>
            </el-table-column>
            <el-table-column label="Форма контроля">
                <el-table-column
                    label="Экзамен"
                    prop="exam1">
                </el-table-column>
                <el-table-column
                    label="Зачет"
                    prop="exam2">
                </el-table-column>
                <el-table-column
                    label="Контр."
                    prop="exam3">
                </el-table-column>
            </el-table-column>
            <el-table-column
                label="Практика"
                prop="hsem1">
            </el-table-column>
            <el-table-column
                label="Назначенные преподаватели"
                prop="hteor1">
            </el-table-column>

        </el-table>

        </template>
    </div>
</div>

<!--    $name = \frontend\models\rup\RupSubjects::find()->where('rup_id=11')->all();-->

<!--    $name = \yii\helpers\ArrayHelper::map(\frontend\models\rup\RupSubjects::find()->all(), 'rup_id', 'name');-->

<!--    $tableData = \frontend\models\rup\RupSubjects::findOne([$searchModel->subjects => 2]);-->

    <?php
//            $tableData = \frontend\models\rup\RupSubjects::findOne(['rup_id' => 2]);
//    $date = \yii\helpers\ArrayHelper::getValue($tableData, 'code');
//    $name = \yii\helpers\ArrayHelper::getValue($tableData, 'name');
//    $htotal = \yii\helpers\ArrayHelper::getValue($tableData, 'time');
//    $hsem1 = \yii\helpers\ArrayHelper::getValue($tableData, 'one_sem_time');
//    $hteor1 = \yii\helpers\ArrayHelper::getValue($tableData, 'teory_time');
//    $hprakt1 = \yii\helpers\ArrayHelper::getValue($tableData, 'lab_time');
//    $hsem2 = \yii\helpers\ArrayHelper::getValue($tableData, 'two_sem_time');
//    $hteor2 = \yii\helpers\ArrayHelper::getValue($tableData, 'teory_time');
//    $hprakt2 = \yii\helpers\ArrayHelper::getValue($tableData, 'lab_time');
//    $exam1 = \yii\helpers\ArrayHelper::getValue($tableData, 'exam');
//    $exam2 = \yii\helpers\ArrayHelper::getValue($tableData, 'offset');
//    $exam3 = \yii\helpers\ArrayHelper::getValue($tableData, 'control_work');

    echo $row = WorkloadDiscipline::find()->where($searchModel->workloadRow)->limit(10)->asArray()->all();
    var_dump($row);
    ?>

<script>
        var subjects_array = JSON.parse('<?php echo $json; ?>');
        var startApp = {};
        var init = function () {
            wlApp = new Vue({
                el: '#app',
                data: {

                    currentDate: new Date().toTimeString(),


                    options: [{
                        value: 'Option1',
                        label: 'Option1'
                        }, {
                        value: 'Option2',
                        label: 'Option2'
                        }, {
                        value: 'Option3',
                        label: 'Option3'
                        }, {
                        value: 'Option4',
                        label: 'Option4'
                        }, {
                        value: 'Option5',
                        label: 'Option5'
                    }],
                    value: '',

                    //кафедры
                    departments: [
                        {   value: '0', label: 'Все' }
                    ],
                    filter_department: '0',

                    //группы
                    studentgroups: [
                        {   value: '0', label: 'Все' }
                    ],
                    filter_studentgroup: '0',

                    //дисциплины
                    disciplines: [
                        {   value: '0', label: 'Все' }
                    ],
                    filter_discipline: '0',

                    //формы обучения
                    eduforms: [
                        {   value: '1', label: 'Очная' }
                        , { value: '2', label: 'Заочная' }

                    ],
                    filter_eduform: '',

                    //язык обучения
                    edulangs: [
                        {   value: '1', label: 'Казахский' }
                        , { value: '2', label: 'Русский' }
                    ],
                    filter_edulang: '',

                    //год
                    yearlist: [
                        {   value: '2019', label: '2019' }
                        , { value: '2020', label: '2020' }
                        , { value: '2021', label: '2021' }

                    ],
                    filter_year: '2020',

                    //курс
                    courselist: [
                        {   value: '1', label: '1' }
                        , { value: '2', label: '2' }
                        , { value: '3', label: '3' }
                        , { value: '4', label: '4' }
                    ],
                    filter_course: '',

                    //РУПы
                    rups: [
                        {   value: '0', label: 'Все' }
                    ],
                    filter_rup: '0',


                    tableData: [{
                        date:'asda';
                   }],
                },

                mounted: function () {
                    // `this` указывает на экземпляр vm
                    //console.log('Значение a: ' + this.a)
                    //console.log('load departments');
                    this.initAppProc()
                },

                methods: {

                    initAppProc(){
                        this.fetchDepartments();
                    },

                    fetchDepartments() {
                        //загрузка Кафедр

                        $.ajax({
                            type: 'GET',
                            url: '/workload/workloadgroup/get-departments',
                            data: {
                                //workorderid: orderId,
                                //sendercomment: ''
                            },
                            success: function (result) {
                                if (result) {
                                    wlApp.departments = $.map(JSON.parse(result), function (e) {
                                        return {
                                            value: e.id,
                                            label: e.name
                                        }
                                    });
                                } else {
                                    return [];
                                }
                            },
                            fail: function (data) {
                                //console.log(data);
                                wlApp.$message('Error, request not append');
                            }
                        });

                    },






                    // sendOrderRequestGetExecAccept(orderId) {
                    //     //console.log(orderId);
                    //     $.ajax({
                    //         type: 'POST',
                    //         url: '/workload/workloadgroup/get-departments',
                    //         data: {
                    //             workorderid: orderId,
                    //             sendercomment: ''
                    //         },
                    //         beforeSend: function (xhr) {

                    //             var token = sessionStorage.getItem(startApp.tokenKey);
                    //             xhr.setRequestHeader("Authorization", "Bearer " + token);
                    //         },
                    //         success: function (data) {
                    //             //console.log(data);
                    //             startApp.$message('Request append!');
                    //             startApp.fetchOrderRequests();
                    //         },
                    //         fail: function (data) {
                    //             //console.log(data);
                    //             startApp.$message('Error, request not append');
                    //         }
                    //     });
                    // },
                }

            })
        }();


    </script>



    <style>
    .demo-input-label {
        display: inline-block;
        width: 40px;
    }
    </style>


    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
