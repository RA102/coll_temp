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
      <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>

    <body class="hold-transition skin-black-light sidebar-mini">
   
    <?php $this->beginBody() ?>




<div id="app">
    <!-- Фильтры -->
    <div class="card-body skin-white">
        <div class="row" style="margin-top: 2px;" >
            <div class="col-md-1" >Кафедра
            </div>
            <div class="col-md-5"  >  
                <el-select v-model="value" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" >Форма обучения
            </div>
            <div class="col-md-4"  >  
                <el-select v-model="value" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" >Группа
            </div>
            <div class="col-md-5"  >  
                <el-select v-model="value" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" >Язык обучения
            </div>
            <div class="col-md-4"  >  
                <el-select v-model="value" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" >Дисциплина
            </div>
            <div class="col-md-5"  >  
                <el-select v-model="value" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2" >Курс
            </div>
            <div class="col-md-4"  >  
                <el-select v-model="value" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row" style="margin-top: 12px;" >
            <div class="col-md-1" >Год
            </div>
            <div class="col-md-1"  >  
                <el-select v-model="value" clearable placeholder="Выберите" style="width: 100%;" >
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-1" >РУП
            </div>
            <div class="col-md-3"  >  
                <el-select v-model="value" clearable placeholder="Выберите"  style="width: 100%;" >
                    <el-option
                    v-for="item in options"
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
                    label="Объем учебного времени"
                    prop="name">
                </el-table-column>
            </el-table-column>

        </el-table>

        </template>
    </div>
</div>

<script>
        var startApp = {};
        var init = function () {
            startApp = new Vue({
                el: '#app',
                data: {
                    active_step: 0, 
                    //return { visible: false }
                    cmb_regions: [
                        { value: '1', label: 'Карагандинская область' }
                    ],
                    cmb_regions_value: '1',

                    cmb_colleges: [
                        { value: '1', label: 'Абайский многопрофильный колледж' }
                        , { value: '2', label: 'Аграрный колледж имени Галыма Жарылгапова' }
                        , { value: '3', label: 'Балхашский гуманитарно-технический колледж' }
                        , { value: '4', label: 'Балхашский колледж сервиса' }
                        , { value: '5', label: 'Бухар-Жырауский агротехнический колледж' }
                        , { value: '6', label: 'Горно-металлургический колледж' }
                    ],
                    cmb_colleges_value: '1',

                    abi_input_iin: '',
                    abi_input_email: '',
                    abi_input_phone: '',

                    form_is_agreement: false,
                    search_number: '',
                    search_result_status_show: false,
                    search_result_status: 'info', //'warning', 'success',
                    search_result_text: '',
                    fdoc: '',
                    fdoc_label:'Загрузить ..',

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
                    tableData: [{                        
                        date: '2016-05-06',
                        name: 'Tom',
                        state: 'California',
                        city: 'Los Angeles',
                        address: 'No. 189, Grove St, Los Angeles',
                        zip: 'CA 90036'
                        }, {
                        date: '2016-05-07',
                        name: 'Tom',
                        state: 'California',
                        city: 'Los Angeles',
                        address: 'No. 189, Grove St, Los Angeles',
                        zip: 'CA 90036'
                        }],
                    





                },

                methods: {
                    step_next() {
                        if (this.active_step++ > 2) this.active_step = 0;
                    },

                    step_prev() {
                        if (this.active_step-- < 1) this.active_step = 0;
                    },

                    //проверка заявки
                    search_request_status() {
                        var d = new Date();
                        var n = d.getSeconds();
                        
                        if (n<15){
                            this.search_result_status = 'warning';
                            this.search_result_text = 'Ваша заявка еще обрабатывается';
                        }
                        else {
                            this.search_result_status = 'success';
                            this.search_result_text = 'Ваша заявка обработана, результат отправлен вам на эл.почту';
                        }
                        this.search_result_status_show = true;
                        
                    },

                    load_doc(event) {
                        this.fdoc = this.$refs.fdoc.files[0];
                        this.fdoc_label = this.fdoc.name;
                        //console.log(event.target.files);
                        console.log(this.fdoc);
                    }
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
