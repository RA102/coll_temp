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
            <div class="col-md-1 label-center" style="padding: 8px;"> Кафедра
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

            <div class="col-md-2 label-center" style="padding: 8px;"> Форма обучения
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
            <div class="col-md-1 label-center" style="padding: 8px;"> Преподаватель
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

            <div class="col-md-2 label-center" style="padding: 8px;"> Язык обучения
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
            <div class="col-md-1 label-center" style="padding: 8px;"> Дисциплина
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

            <div class="col-md-2 label-center" style="padding: 8px;"> Курс
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
            <div class="col-md-1 label-center" style="padding: 8px;"> Год
            </div>
            <div class="col-md-1 yearDiv"  >  
                <el-select v-model="filter_year"  style="width: 100%;" >
                    <el-option
                    v-for="item in yearlist"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-1 label-center" style="padding: 8px;"> РУП
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
                    <div v-for="(group,index) in props.row.groups" :key="index" >
                    <div class="row" >
                        <div class="col-md-2 column-name">
                            {{getGroupName(group.groupId).name}}
                        </div>
                        <div class="col-md-1 column">
                            {{group.total}}
                        </div>
                        <template v-for="(grades,gradeIndex) in group.semester" >
                            <div class="col-md-1 column" :key="gradeIndex">
                                {{group.semester[gradeIndex]}}
                            </div>
                            <div class="col-md-1 column">
                                {{group.theory[gradeIndex]}}
                            </div>
                            <div class="col-md-1 column">
                                {{group.laboratory[gradeIndex]}}
                            </div>
                        </template>
                        <template >
                            <div class="col-md-1 mr-6  ">                            
                                <el-button 
                                    type="warning"
                                    @click="updateGroupData(props.row.id,group.num)" 
                                    icon="el-icon-edit" round>Изменить</el-button>
                            </div>
                            <div class="col-md-1 ml-6 ">
                            <el-button 
                                    type="danger"
                                    @click="openDialogDelete(props.row.id,group.num)" 
                                    icon="el-icon-delete" round>Удалить</el-button>
                            </div>
                        </template>
                        
                    </div>
                   </div>
                   <div class="col-md-1">
                             <el-button 
                                    type="primary"
                                    @click="createGroupData(props.row.id)" 
                                    icon="el-icon-plus" plain></el-button>
                   </div>
                </div>
            </el-table-column>
            <el-table-column
                label="Индекс"
                prop="index">
            </el-table-column>
            <el-table-column
                label="Найменования дисциплина"
                prop="name">
            </el-table-column>
            <el-table-column label="Объем учебного времени">
                <el-table-column
                    label="Всего"
                    prop="total">
                </el-table-column>
                <el-table-column
                    label="1 сем."
                    prop="semester[0]">
                </el-table-column>                
                <el-table-column
                    label="теор."
                    prop="theory[0]">
                </el-table-column>                
                <el-table-column
                    label="прак., лаб."
                    prop="laboratory[0]">
                </el-table-column> 
                <el-table-column
                    label="2 сем."
                    prop="semester[1]">
                </el-table-column>                
                <el-table-column
                    label="теор."
                    prop="theory[1]">
                </el-table-column>                
                <el-table-column
                    label="прак., лаб."
                    prop="laboratory[1]">
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
                label="Группы"
                prop="groupsName">
            </el-table-column>                

        </el-table>

        </template>
        


           <!-- Dialog window -->
    <v-dialog
      v-model="dialogWindow"
      max-width="550"
    >
      <v-card>
        <v-card-title class="headline">Изменение данных группы</v-card-title>

        <v-form
            ref="form" 
            v-model="valid"
            class="pl-6 pr-6 d-flex flex-wrap justify-space-around align-center">
            <span class="d-flex justify-space-around align-center groupName">
                Имя:
                <v-select
                    v-model="selectedGroup"
                    :items="groupSelect"
                    item-text="name"
                    item-value="id"
                    class="ml-4"
                ></v-select>
            </span>
            <span v-for="(semesterTemp,index) in semester"  :key="'semester'+index">
                Семестер номер {{index+1}}
                <v-text-field
                    :rules="textFieldRules"
                    type="number"
                    v-model="semester[index]"
                    class="dialogInput"
                 ></v-text-field>
            </span>
            <span v-for="(item,index) in theory" :key="'theory'+index">
                Теория {{index+1}} семестр
                <v-text-field 
                    :rules="textFieldRules"
                    v-model="theory[index]" 
                    type="number"
                    class="dialogInput"
                    
                    >
                </v-text-field>
            </span>
            <span v-for="(item,index) in laboratory " :key="'laboratory'+index">
                Практическая работа {{index+1}} семестр
                <v-text-field 
                    :rules="textFieldRules"
                    v-model="laboratory[index]" 
                    type="number"
                    class="dialogInput"
                    >
                </v-text-field>
            </span>
        </v-form>

            <v-card-actions>
                <v-spacer></v-spacer>

                <el-button 
                    type="primary"
                    @click="clearDialogWindow()"
                    plain>Отмена</el-button>
                <el-button 
                    type="primary"
                    @click="saveDialogData()"
                    >Сохранить</el-button>
            </v-card-actions>
            </v-card>
        </v-dialog>


<!-- Dialog окно для потверждения удаления -->
        <v-dialog
            v-model="dialogDeleteGroup"
            max-width="400"
            >
            <v-card class="dialogDelete">
                <v-card-title class="headline">Подтвердите удаление</v-card-title>
                <v-card-text class="pb-1">
                    Это удалит информацию о группе.Продолжать?
                </v-card-text>
                <v-card-actions class="ml-4 mt-2 d-flex justify-end">
                <el-button 
                    type="primary"
                    @click="cancelDialogDelete()"
                    icon="el-icon-edit" plain>Отмена</el-button>
                <el-button 
                    type="primary"
                    @click="confirmDelete()"
                    icon="el-icon-edit" >Подтвердить</el-button>
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

                    dialogDeleteGroup:false,
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
                        { value: '', label: 'Все' }
                    ],
                    filter_studentgroup: '',

                    //дисциплины
                    disciplines: [
                        { value: '', label: 'Все' }
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
                        { value: '', label: 'Все'    },
                        {value: '2019', label: '2019'},
                        {value: '2020', label: '2020'},
                        {value: '2021', label: '2021'}
                    ],
                    filter_year: '',
                    
                    //курс
                    courselist: [
                      { value: '1', label: '1' },
                      { value: '2', label: '2' },
                      { value: '3', label: '3' },
                      { value: '4', label: '4' }
                    ],
                    filter_course: '',

                    //РУПы
                    rups: [
                        { value: '', label: 'Все' }
                    ],
                    filter_rup: '',

                    tableData: [{    
                        id:1,                    
                        index: 'gg12',
                        name: 'GG-12-2',
                        groupsName:"",
                        total:40,
                        semester:[61,33],
                        theory:[94,52],
                        laboratory:[2,1],
                        groups:[
                            {
                                num:1,
                                groupId:1,
                                total:20,
                                semester:[10,10],
                                theory:[10,10],
                                laboratory:[0,0]
                            },
                            {
                                num:2,
                                groupId:2,
                                total:20,
                                semester:[20,30],
                                theory:[50,20],
                                laboratory:[1,5]
                            }
                        ]
            
                        }, 
                        {
                        id:2,
                        index: '2016-05-07',
                        name: 'Tom',
                        groupsName:"",
                        total:30,
                        semester:[10,10],
                        theory:[10,10],
                        laboratory:[0,0],
                        
                        groups:[
                            {
                                num:1,
                                groupId:4,
                                total:20,
                                semester:[10,10],
                                theory:[10,10],
                                laboratory:[0,0]
                            }
                        ]
                    }],
                    

                    semester:[0,0],
                    theory:[0,0],
                    laboratory:[0,0],
                    groupNum:0,
                    tableDataId:0,
                    
                    groups:[
                        {
                            id:1,
                            name:"rr-12-2",
                            disciplineId:1,
                            selected:1,
                        },
                        {
                            id:2,
                            name:"cc-11-44",
                            disciplineId:1,
                            selected:1,
                        },
                        {
                            id:3,
                            name:"tt-42-6",
                            disciplineId:1,
                            selected:0,
                        },
                        {
                            id:4,
                            name:"qr-89-32",
                            disciplineId:2,
                            selected:1,
                        },

                    ],

                    textFieldRules:[
                        v=>v<101 && v>=0||"Значение от 0 до 100"
                    ],
                    selectedGroup:{},
                    groupSelect:[]

                
                    }
                },

                mounted: function () {
                    // `this` указывает на экземпляр vm
                    //console.log('Значение a: ' + this.a)
                    //console.log('load departments');
                    this.initAppProc()
                },

                watch: {
                    filter_department: function () {
                        this.fetchGroups();
                        this.fetchDisciplines();
                    },

                    filter_eduform: function () {
                        this.fetchGroups();
                    },

                    filter_edulang: function () {
                        this.fetchGroups();
                    },
                    filter_course: function () {
                        this.fetchGroups();
                    },

                    filter_year: function () {
                        this.getRups();
                    },

                    filter_discipline: function() {
                        this.getRups();
                    },

                },

                methods: {
                    initAppProc(){

                        //this.fetchDepartments();
                        this.fetchGroups();
                        this.fetchDisciplines();
                        this.getEducationForm();
                        this.getEduLangs();
                        this.getRups();

                        this.console();

                        // this.fetchDepartments();
                        this.countAgainAllFields();

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

                    getRups() {
                      $.ajax({
                        type: 'GET',
                        url:'/workload/workloadgroup/get-rups?year=' + this.filter_year + '&discipline=' + this.filter_discipline,
                        data: {},
                        success: function(data) {
                          if(data) {
                            wlApp.rups =  $.map(JSON.parse(data), function (e) {
                              return {
                                value: e.id,
                                label: e.captionRu
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

                    updateTeacherData(id,num) {
                        //Изменить учительские данные
                    },
                    updateGroupData(id,num){
                        //Изменить данные группы
                        this.clearDialogWindow();
                        

                        this.tableDataId=id;
                        this.groupNum=num;
                        this.updateOrGetTecherData(id,num,0);
                        this.groupSelect=this.getGroupsByDiscipline(id);
                        this.groupSelect.unshift(this.getGroupName(this.selectedGroup));
                        //отобразить окно
                        this.dialogWindow=true;
                        
                    },
                    createGroupData(id){
                        //Создаем новую
                        this.clearDialogWindow();
                        this.groupSelect=this.getGroupsByDiscipline(id);
                        if(this.groupSelect.length!=0){                            
                            this.tableDataId=id;     
                            this.dialogWindow=true;
                        }else{
                            const h = this.$createElement;
                            this.$notify.info({
                                title: 'Ошибка создания',
                                message: h('i', { style: 'color: danger' }, 'Все группы заполнены'),
                                duration:2000
                            });
                        }
                        

                    },
                    clearDialogWindow(){
                        //Закрваем диалоговое окно с кнопки отмена
                        this.dialogWindow=false;
                        this.semester=[0,0];
                        this.theory=[0,0];
                        this.laboratory=[0,0];
                        this.tableDataId=0;
                        this.groupNum=0;
                        this.groupSelect=[];
                    },
                    updateOrGetTecherData(id,num,type){
                        //type 0=получить 1=сохранить изменение  2=удалить 3-сохранить новое
                        for(let i=0;i<this.tableData.length;i++){
                            if(this.tableData[i].id==id){
                               
                                for(let j=0;j<this.tableData[i].groups.length;j++){
                                    if(this.tableData[i].groups[j].num==num){
                                        if(type==0){                                        
                                            this.selectedGroup=this.getGroupName(this.tableData[i].groups[j].groupId).id;

                                            this.semester[0]=this.tableData[i].groups[j].semester[0];
                                            this.semester[1]=this.tableData[i].groups[j].semester[1];
                                            
                                            this.theory[0]=this.tableData[i].groups[j].theory[0];
                                            this.theory[1]=this.tableData[i].groups[j].theory[1];

                                            this.laboratory[0]=this.tableData[i].groups[j].laboratory[0];
                                            this.laboratory[1]=this.tableData[i].groups[j].laboratory[1];


                                        }else if(type==1){

                                            this.deniedSelected(this.tableData[i].groups[j].groupId,0);
                                            this.deniedSelected(this.selectedGroup,1);

                                            this.tableData[i].groups[j].groupId=Number(this.selectedGroup);

                                            this.tableData[i].groups[j].semester[0]=Number(this.semester[0]);
                                            this.tableData[i].groups[j].semester[1]=Number(this.semester[1]);

                                            this.tableData[i].groups[j].theory[0]=Number(this.theory[0]);
                                            this.tableData[i].groups[j].theory[1]=Number(this.theory[1]);


                                            this.tableData[i].groups[j].laboratory[0]=Number(this.laboratory[0]);
                                            this.tableData[i].groups[j].laboratory[1]=Number(this.laboratory[1]);

                                        }else if(type==2){
                                            this.deniedSelected(this.tableData[i].groups[j].groupId,0);
                                            this.tableData[i].groups.splice(j,1);                                          
                                        }break;
                                    }
                                    
                                }
                                if(type==3){
                                    //Это временно пока не начну получать сервера id 
                                    let lastNum=0;
                                    if(this.tableData[i].groups.length!=0){
                                        lastNum=this.tableData[i].groups[this.tableData[i].groups.length-1].num;
                                    }
                                    this.deniedSelected(this.selectedGroup,1);

                                    let tempSemester=[Number(this.semester[0]),Number(this.semester[1])]
                                    let tempTheory=[Number(this.theory[0]),Number(this.theory[1])]
                                    let tempLaboratory=[Number(this.laboratory[0]),Number(this.laboratory[1])]

                                    this.tableData[i].groups.push({
                                                num:lastNum=lastNum+1,
                                                groupId:this.selectedGroup,
                                                total:20,
                                                semester:tempSemester,
                                                theory:tempTheory,
                                                laboratory:tempLaboratory
                                        });
                                }break;                                
                            }
                        }

                    },
                    saveDialogData(){//TODO нужно что бы при открывания правильно группу показывал 
                        //сохраняем данные
                        if(this.$refs.form.validate()){
                            if(this.groupNum!=0){ //если есть groupNum значит происходить изменения
                                this.updateOrGetTecherData(this.tableDataId,this.groupNum,1);                                
                            }else{
                                //Нужно отправять на сервер ждать ответ потом добавлять groupNum
                                this.updateOrGetTecherData(this.tableDataId,this.groupNum,3);
                            }
                            this.countAgainAllFields();
                            this.clearDialogWindow();
                        }
                    },
                    confirmDelete(){
                        this.dialogDeleteGroup=false;                        
                        this.updateOrGetTecherData(this.tableDataId,this.groupNum,2);
                        this.countAgainAllFields();
                    },
                    openDialogDelete(id,num){
                        this.tableDataId=id;
                        this.groupNum=num;                        
                        this.dialogDeleteGroup=true;
                    },
                    cancelDialogDelete(){
                        this.dialogDeleteGroup=false;
                        this.tableDataId=0;
                        this.groupNum=0;
                    },
                    getGroupsByDiscipline(disciplineId){
                        let answer=[];
                        for(let i=0;i<this.groups.length;i++){
                            if(this.groups[i].disciplineId==disciplineId && this.groups[i].selected==0){
                                answer.push(this.groups[i]);
                            }
                        }
                        return answer;
                    },
                    getGroupName(id){//Получит название группы по id
                        for(let i=0;i<this.groups.length;i++){
                            if(this.groups[i].id==id){
                                return this.groups[i];
                            }
                        }
                    },
                    deniedSelected(id,type){//Указать используемую  группу или наоборот
                        //type 0 == selected =0 
                        for(let i=0;i<this.groups.length;i++){
                            if(this.groups[i].id==id){
                                this.groups[i].selected=type;
                                break;
                            }
                        }
                    },
                    countAgainAllFields(){
                        for(let i=0;i<this.tableData.length;i++){
                            let total=0;
                            let semester=[0,0];
                            let theory=[0,0];
                            let laboratory=[0,0];
                            let groupsName="";

                            for(let j=0;j<this.tableData[i].groups.length;j++){
                                total+=this.tableData[i].groups[j].total;


                                semester[0]+=this.tableData[i].groups[j].semester[0];
                                semester[1]+=this.tableData[i].groups[j].semester[1];
                                // console.log("sem[0]:"+semester[0]+"    type:"+typeof semester[0]);
                                // console.log("this.sem[0]:"+this.tableData[i].groups[j].semester[0]+"    type:"+typeof this.tableData[i].groups[j].semester[0]);


                                theory[0]+=this.tableData[i].groups[j].theory[0];
                                theory[1]+=this.tableData[i].groups[j].theory[1];

                                laboratory[0]+=this.tableData[i].groups[j].laboratory[0];
                                laboratory[1]+=this.tableData[i].groups[j].laboratory[1];
                            }
                            for(let j=0;j<this.groups.length;j++){
                                if(this.groups[j].disciplineId==this.tableData[i].id && this.groups[j].selected==1){
                                    if(j!=this.groups.length){
                                        groupsName+=this.groups[j].name+",";
                                    }else{
                                        groupsName+=this.groups[j].name;
                                    }
                                }
                            }
                            this.tableData[i].groupsName=groupsName;
                            this.tableData[i].total=total;
                            this.tableData[i].semester=semester;
                            this.tableData[i].theory=theory;
                            this.tableData[i].laboratory=laboratory;
                        }
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
    .dialogInput{
        width:200px;
    }
    .dialogDelete{
        height:155px;
    }
    .groupName{
        width:400px;
    }
    .column-name{
        display:flex;
        justify-content:center;
        align-items:center;

    }
    .column {
        padding-right:10px;
        display:flex;
        justify-content:flex-start;
        align-items:center;
    }
    .nameDisciplines{
        width:300px;
    }
    .demo-input-label {
        display: inline-block;
        width: 40px;
    }

    .label-center{
        display:flex;
        align-items:center;
    }
    .yearDiv{
        min-width:105px;
    }
    </style>    


    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>   
