<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\rup\RupRootsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
    <!-- Vuetify  -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <!-- Vuetify  -->

      <!-- import Vue before Element -->
    <!-- <script src="https://unpkg.com/vue/dist/vue.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>



    <body class="hold-transition skin-black-light sidebar-mini">
   
    <?php $this->beginBody() ?>




<v-app id="app">
    <!-- Фильтры -->
    <div class="card-body skin-white">
        <div class="row" style="margin-top: 2px;" >
            <div class="col-md-1" style="padding: 8px;"> Кафедра
            </div>
            <div class="col-md-5"  >  
                <el-select v-model="filter_department" clearable placeholder="Выберите" style="width: 100%;" >  <!--@change="fetchDisciplines"-->
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
                <el-select v-model="filter_eduform" clearable placeholder="Выберите"  style="width: 100%;">
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
    <div class="card-body skin-white" >
        <template>
        <el-table
            :data="tableData"
            style="width: 100%">
            <el-table-column type="expand">
                <div  slot-scope="props">
                    <div v-for="(teacher,index) in props.row.teachers" :key="index" >
                    <div class="row" >
                        <div class="col-md-2 column-name">
                            {{teacher.name}}
                        </div>
                        <div class="col-md-1 column">
                            {{teacher.total}}
                        </div>
                        <template v-for="(grades,gradeIndex) in teacher.semester" >
                            <div class="col-md-1 column" :key="gradeIndex">
                                {{teacher.semester[gradeIndex]}}
                            </div>
                            <div class="col-md-1 column">
                                {{teacher.theory[gradeIndex]}}
                            </div>
                            <div class="col-md-1 column">
                                {{teacher.laboratory[gradeIndex]}}
                            </div>
                        </template>
                        <template class="col-md-2">
                            <div class="col-md-1 mr-4">
                            <v-btn 
                                @click="updateTeacherData(props.row.id,teacher.num)"
                                type="success" 
                                 rounded >Изменить</v-btn>
                            </div>
                            <div class="col-md-1 ml-4">
                            <v-btn                                 
                                type="error" 
                                @click="openDialogDelete(props.row.id,teacher.num)"
                                rounded >Удалить</v-btn>
                            </div>
                        </template>
                        
                    </div>
                   </div>
                </div>
            </el-table-column>
            <el-table-column
                label="Индекс"
                prop="date">
            </el-table-column>
            <el-table-column
                label="Найменования дисциплина"
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
        


           <!-- Dialog window -->
    <v-dialog
      v-model="dialogWindow"
      max-width="550"
    >
      <v-card>
        <v-card-title class="headline">Изменение данных учителя</v-card-title>

        <v-form
            ref="form" 
            v-model="valid"
            class="pl-6 pr-6 d-flex flex-wrap justify-space-around align-center">
            <span class="d-flex justify-space-around align-center teacherName">
                Имя:
                <v-text-field v-model="name" class="ml-4">
                </v-text-field>
            </span>
            <span v-for="(semesterTemp,index) in semester"  :key="'semester'+index">
                Семестер номер {{index+1}}
                <v-text-field
                    :rules="textFieldRules"
                    type="number"
                    v-model="semester[index]"
                    max="100"

                 ></v-text-field>
            </span>
            <span v-for="(item,index) in theory" :key="'theory'+index">
                Теория {{index+1}} семестр
                <v-text-field 
                    :rules="textFieldRules"
                    v-model="theory[index]" 
                    type="number"
                    max="100"
                    
                    >
                </v-text-field>
            </span>
            <span v-for="(item,index) in laboratory " :key="'laboratory'+index">
                Практическая работа {{index+1}} семестр
                <v-text-field 
                    :rules="textFieldRules"
                    v-model="laboratory[index]" 
                    type="number"
                    max="100"
                    >
                </v-text-field>
            </span>
        </v-form>

            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                  color="green darken-1"
                  text
                  @click="saveDialogData()"
                >
                  Сохранить
                </v-btn>

                <v-btn
                color="yellow darken-1"
                text
                @click="clearDialogWindow()"
                 >
                    Отмена
                </v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogDeleteTeacher"
            max-width="400"
            >
            <v-card class="dialogDelete">
                <v-card-title class="headline">Подтвердите удаление</v-card-title>
                <v-card-actions class="ml-4 mt-2">
                    <v-btn class="mr-6" color="error" @click="confirmDelete()">Подтвердить</v-btn>
                    <v-btn color="success" @click="cancelDialogDelete()">Отмена</v-btn>
                <v-card-actions>
            </v-card>
        </v-dialog>
    </div>
 
</v-app>


<script>
        var startApp = {};
        var init = function () {
            wlApp = new Vue({
                el: '#app',
                vuetify:new Vuetify(),
                data(){
                    return{
                    valid:true,

                    dialogDeleteTeacher:false,
                    dialogWindow:false,

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
                        {value: '', label: 'Все' },
                        {value: 36, label: 'Департамент №1'},
                        {value: 24, label: 'Департамент №2'},
                    ],
                    // filter_department: '',
                    filter_department: '',

                    //группы
                    studentgroups: [
                        {   value: '', label: 'Все' }
                    ],
                    filter_studentgroup: '',

                    //дисциплины
                    disciplines: [
                        {   value: '', label: 'Все' }
                    ],
                    filter_discipline: '',
                    
                    //формы обучения
                    eduforms: [
                        { value: '', label: 'Все' },

                    ],
                    filter_eduform: '',  

                    //язык обучения
                    edulangs: [
                        { value: '', label: 'Все' },
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
                        id:1,                    
                        date: '2016-05-06',
                        name: 'Tom',
                        state: 'California',
                        city: 'Los Angeles',
                        address: 'No. 189, Grove St, Los Angeles',
                        zip: 'CA 90036',
                        teachers:[
                            {
                                num:1,
                                name:"Омарова С.К.",
                                total:20,
                                semester:[10,10],
                                theory:[10,10],
                                laboratory:[0,0]
                            },
                            {
                                num:2,
                                name:"Komarov R.X.",
                                total:20,
                                semester:[20,30],
                                theory:[50,20],
                                laboratory:[1,5]
                            }
                        ]
            
                        }, 
                        {
                        id:2,
                        date: '2016-05-07',
                        name: 'Tom',
                        state: 'California',
                        city: 'Los Angeles',
                        address: 'No. 189, Grove St, Los Angeles',
                        zip: 'CA 90036',
                        teachers:[
                            {
                                num:1,
                                name:"Омарова С.К.",
                                total:20,
                                semester:[10,10],
                                theory:[10,10],
                                laboratory:[0,0]
                            }
                        ]
                    }],
                    

                    name:"",
                    semester:[0,0],
                    theory:[0,0],
                    laboratory:[0,0],
                    teacherNum:0,
                    tableDataId:0,

                    textFieldRules:[
                        v=>v<101 && v>=0||"Значение от 0 до 100"
                    ]

                
                    }
                },

                mounted: function () {
                    // `this` указывает на экземпляр vm
                    //console.log('Значение a: ' + this.a)
                    //console.log('load departments');
                    this.initAppProc()
                },

                watch: {
                  filter_department: function() {
                      this.fetchGroups();
                      this.fetchDisciplines();
                  },

                  filter_eduform: function() {
                      this.fetchGroups();
                  },

                  filter_edulang: function() {
                    this.fetchGroups();
                  },
                  filter_course: function() {
                    this.fetchGroups();
                  },

                },

                methods: {
                    initAppProc(){
                        //this.fetchDepartments();
                        this.fetchGroups();
                        this.fetchDisciplines();
                        this.getEducationForm();
                        this.getEduLangs();
                        this.console();
                    },

                    // fetchDepartments() {
                    //     //загрузка Кафедр
                    //
                    //     $.ajax({
                    //         type: 'GET',
                    //         url: '/workload/workloadgroup/get-departments',
                    //         data: {
                    //             //workorderid: orderId,
                    //             //sendercomment: ''
                    //         },
                    //         success: function (result) {
                    //             if (result) {
                    //                 wlApp.departments = $.map(JSON.parse(result), function (e) {
                    //                     return {
                    //                         value: e.id,
                    //                         label: e.name
                    //                     }
                    //                 });
                    //             } else {
                    //                 return [];
                    //             }
                    //         },
                    //         fail: function (data) {
                    //             //console.log(data);
                    //             wlApp.$message('Error, request not append');
                    //         }
                    //     });
                    //
                    // },

                    // Загрузить группы
                    fetchGroups() {
                        $.ajax({
                            type: 'GET',
                            url: '/workload/workloadgroup/get-groups?department_id=' + this.filter_department + '&edu_form=' + this.filter_eduform + '&edu_lang=' + this.filter_edulang + '&curs=' + this.filter_course,
                            data: {},
                            success: function (data) {
                                if (data) {
                                    wlApp.studentgroups = $.map(JSON.parse(data), function(e) {
                                       return {
                                           value: e.id,
                                           label: JSON.parse(e.caption).ru
                                       }
                                    });
                                } else {
                                    return [];
                                }

                            },
                        });
                    },

                    // получить дисциплины
                    fetchDisciplines() {
                        $.ajax({
                            type: 'GET',
                            url: '/workload/workloadgroup/get-disciplines?id=' + this.filter_department,
                            data: {},
                            success: function (data) {
                                if (data) {
                                    wlApp.disciplines = $.map(JSON.parse(data), function (e) {
                                        return {
                                            value: e.id,
                                            label: JSON.parse(e.caption).ru
                                        }
                                    });
                                } else {
                                    return [];
                                }

                            },
                        });
                    },

                    getEducationForm() {
                        $.ajax({
                            type: 'GET',
                            url:'/workload/workloadgroup/get-education-form',
                            data: {},
                            success: function(data) {
                              if(data) {
                                  wlApp.eduforms =  $.map(JSON.parse(data), function (value, key) {
                                      return {
                                          value: key,
                                          label: value,
                                      }
                                  });
                              } else {
                                  return [];
                              }
                            },
                        });
                    },

                    getEduLangs() {
                      $.ajax({
                        type: 'GET',
                        url:'/workload/workloadgroup/get-edu-langs',
                        data: {},
                        success: function(data) {
                          if(data) {
                            wlApp.edulangs =  $.map(JSON.parse(data), function (value, key) {
                              return {
                                value: key,
                                label: value,
                              }
                            });
                          } else {
                            return [];
                          }
                        },
                      });

                    },

                    console() {
                      console.log(this.eduforms);
                    },

                    updateTeacherData(id,num){
                        //Изменить учительские данные
                        this.tableDataId=id;
                        this.teacherNum=num;
                        this.updateOrGetTecherData(id,num,0);
                        //отобразить окно
                        this.dialogWindow=true;
                        
                    },
                    clearDialogWindow(){
                        //Закрваем диалоговое окно с кнопки отмена
                        this.dialogWindow=false;
                        this.name="";
                        this.semester=[0,0];
                        this.theory=[0,0];
                        this.laboratory=[0,0];
                        this.tableDataId=0;
                        this.teacherNum=0;
                    },
                    updateOrGetTecherData(id,num,type){
                        //type 0=получить 1=сохранить 2=удалить
                        for(let i=0;i<this.tableData.length;i++){
                            if(this.tableData[i].id==id){
                               
                                for(let j=0;j<this.tableData[i].teachers.length;j++){
                                    if(this.tableData[i].teachers[j].num==num){
                                        if(type==0){                                         
                                            
                                            this.name=this.tableData[i].teachers[j].name;

                                            this.semester[0]=this.tableData[i].teachers[j].semester[0];
                                            this.semester[1]=this.tableData[i].teachers[j].semester[1];
                                            
                                            this.theory[0]=this.tableData[i].teachers[j].theory[0];
                                            this.theory[1]=this.tableData[i].teachers[j].theory[1];

                                            this.laboratory[0]=this.tableData[i].teachers[j].laboratory[0];
                                            this.laboratory[1]=this.tableData[i].teachers[j].laboratory[1];


                                        }else if(type==1){

                                            this.tableData[i].teachers[j].name=this.name;
                                            this.tableData[i].teachers[j].semester=this.semester;
                                            this.tableData[i].teachers[j].theory=this.theory;
                                            this.tableData[i].teachers[j].laboratory=this.laboratory;

                                        }else if(type==2){
                                            
                                            this.tableData[i].teachers.splice(j,1);
                                           

                                        }break;
                                    }
                                }break;                                
                            }
                        }

                    },
                    saveDialogData(){
                        //сохраняем данные
                        if(this.$refs.form.validate()){
                            this.updateOrGetTecherData(this.tableDataId,this.teacherNum,1);
                            this.clearDialogWindow();
                        }
                    },
                    confirmDelete(){
                        this.dialogDeleteTeacher=false;
                        this.updateOrGetTecherData(this.tableDataId,this.teacherNum,2)
                    },
                    openDialogDelete(id,num){
                        this.tableDataId=id;
                        this.teacherNum=num;                        
                        this.dialogDeleteTeacher=true;
                    },
                    cancelDialogDelete(){
                        this.dialogDeleteTeacher=false;
                        this.tableDataId=0;
                        this.teacherNum=0;
                    }




                    

                   

                    
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
    .dialogDelete{
        height:150px;
    }
    .teacherName{
        width:400px;
    }
    .column-name{
        display:flex;
        justify-content:center;
    }
    .column {
        padding-right:10px;
        display:flex;
        justify-content:flex-start;
    }
    .nameDisciplines{
        width:300px;
    }
    .demo-input-label {
        display: inline-block;
        width: 40px;
    }
    </style>    


    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>   
