<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


    $this->title = 'Бiлiмал. Электронды колледж';
//$this->params['breadcrumbs'][] = $this->title;
    dmstr\web\AdminLteAsset::register($this);
    frontend\assets\AppAsset::register($this);
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
    <header class="main-header">

<nav class="navbar navbar-static-top" role="navigation">
    <div class="pull-left" style="display: flex;align-items: center;">
        <a href="/" class=" navbar-brand">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <span class="navbar-text px-3 navbar-title hidden-xs">
            Бiлiмал. Электронды колледж
        </span>
    </div>
    <div class="navbar-custom-menu" style="display: flex;align-items: center; height: 68px;">
        <h5>Государственная услуга «Прием документов и зачисление на обучение в организациях образования, <br>реализующих образовательные программы технического и профессионального образования»</h5>
    </div>


</nav>
</header>

        <div class="row" style="text-align: center; ">
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>
            <div class="col-md-8" >
                <div >
                    <p ><h4>Добро пожаловать, уважаемые родители и абитуриенты!</h4></p>
                    <p >Вы можете подать электронное заявление в колледж для зачисления. Срок оказания услуги 5 дней. Услуга предоставляется бесплатно.</p>
                </div>       

            </div>
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>
        </div>        
        <div class="row" >
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>            
            <div class="col-md-8" style="background-color: #79d279; height: 4px; margin-bottom: 6px;">
                
            </div>
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>            	
        </div>            
        <div class="row" style="height: 700px;">
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <el-steps :active="active_step" finish-status="success" >
                                <el-step title="Шаг 1" description="Необходимые документы"></el-step>
                                <el-step title="Шаг 2" description="Выбор колледжа"></el-step>
                                <el-step title="Шаг 3" description="Регистрация заявителя"></el-step>
                                <el-step title="Шаг 4" description="Регистрация заявки"></el-step>
                            </el-steps>

                        </div>
                    </div>
                </div>                                                
                <div class="row" style="margin-top: 24px; height: 480px;" >
                    <div class="col-md-12">
                        <div class="row" v-show="active_step == 0">
                            <div class="col-md-2">
                            </div>    
                            <div class="col-md-10">
                                <p>Перечень документов, необходимых для оказания государственной услуги при обращении услугополучателя к услугодателю:</p>
                                        
                                <ul>
                                    <li>скан-копия документа, удостоверяющего личность (для идентификации личности);</li>
                                    <li>фотографии размером 3х4 см, в электронном формате;</li>
                                    <li>скан-копия документа об образовании;</li>
                                    <li>скан-копия медицинской справки формы 086-У</li>
                                </ul>

                                <p>Услугополучатели – иностранцы и лица без гражданства, также представляют в скан-копии документа, определяющий их статус, с отметкой о регистрации по месту проживания:</p>

                                <ul>
                                    <li>иностранец - вид на жительство иностранца в Республике Казахстан;</li>
                                    <li>лицо без гражданства - удостоверение лица без гражданства;</li>
                                    <li>беженец - удостоверение беженца;</li>
                                    <li>лицо, ищущее убежище – свидетельство лица, ищущего убежище;</li>
                                    <li>оралман – удостоверение оралмана;</li>
                                </ul>
                            </div>
                        </div> 

                        <div class="row" v-show="active_step == 1">
                            <div class="col-md-12">
                                <div class="row" >
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >        
                                        Выберите регион
                                    </div>    
                                    <div class="col-md-6" >
                                        <template>
                                            <el-select v-model="cmb_regions_value" placeholder="Выберите регион" style="width: 100%;">
                                                <el-option
                                                v-for="item in cmb_regions"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </template>
                                    </div> 
                                </div> 

                                <div class="row" style="margin-top: 12px;" >
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >        
                                        Выберите колледж
                                    </div>    
                                    <div class="col-md-6" >
                                        <template>
                                            <el-select v-model="cmb_colleges_value" placeholder="Выберите колледж" style="width: 100%;">
                                                <el-option
                                                v-for="item in cmb_colleges"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </template>
                                    </div> 
                                </div> 

                            </div>
                        </div>
                        <div class="row" v-show="active_step == 2">
                            <div class="col-md-12">
                                <div class="row" >
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >ИИН абитуриента
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="Введите ИИН" v-model="abi_input_iin" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >для идентификации
                                    </div>                                     
                                </div> 
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Фамилия
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="Фамилия" v-model="abi_input_phone" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >
                                    </div> 
                                </div> 
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Имя
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="Имя" v-model="abi_input_phone" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >
                                    </div> 
                                </div>
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Отчество (при наличии)
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="Отчество" v-model="abi_input_phone" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >
                                    </div> 
                                </div>                                                                                               
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Адрес электронной почты
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="abitur@mail.kz" v-model="abi_input_email" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >для регистрации и оповещений
                                    </div> 

                                </div> 
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Номер мобильного телефона
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="7-777-111-22-33" v-model="abi_input_phone" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >для контакта с заявителем
                                    </div> 

                                </div> 
                                <div class="row" style="margin-top: 12px;">
                                    <div class="col-md-2" >  
                                    </div>
                                    <div class="col-md-10">
                                        <b>ТРЕБУЕТСЯ ВАШЕ СОГЛАСИЕ ПО СЛЕДУЮЩИМ ПУНКТАМ:</b>
                                        <ol>
                                            <li>Я подтверждаю, что вся представленная информация является достоверной и точной;</li>
                                            <li>Я несу ответственность в соответствии с действующим законодательством РК за предоставление заведомо ложных или неполных сведений;</li>
                                            <li>Я выражаю свое согласие на необходимое использование и обработку своих персональных данных, в том числе в информационных системах;</li>
                                            <li>Со сроками оказания государственной услуги ознакомлен;</li>
                                            <li>В случае обнаружения представленной пользователями неполной и/или недостоверной информации, услугодатель ответственности не несет.</li>
                                        </ol>

                                        <el-checkbox v-model="form_is_agreement" label="Я подтверждаю свое согласие со всеми вышеперечисленными пунктами" border></el-checkbox>


                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row" v-show="active_step == 3">
                            <div class="col-md-12">
                                <div class="row" >
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Удостоверение личности
                                    </div>    
                                    <div class="col-md-4" >
                                        <label for="file"> {{fdoc_label}}</label>
                                    </div> 
                                    <div class="col-md-4" >
                                        
                                        <input  type="file" id="file" ref="fdoc" @change="load_doc" accept="image/jpeg, image/png" style="display: none"> </el-input>
                                    </div>                                     
                                </div> 
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-2" >        
                                    </div>
                                    <div class="col-md-2" >Фамилия
                                    </div>    
                                    <div class="col-md-4" >
                                        <el-input  placeholder="Фамилия" v-model="abi_input_phone" clearable> </el-input>
                                    </div> 
                                    <div class="col-md-4" >
                                    </div> 
                                </div> 
                            </div>
                        </div>                                                                                  
                    </div>
                </div> 
                <!-- кнопки -->
                <div class="row" style="margin-top: 12px;" >
                        <div class="col-md-4" >        
                        </div>
                        <div class="col-md-2" >        
                            <el-button  type="primary" @click="step_prev" v-show="active_step > 0">Вернуться</el-button>        
                        </div>
                        <div class="col-md-2" >        
                            <el-button  type="primary" @click="step_next" v-show="active_step < 2 || form_is_agreement == true">Продолжить</el-button>        
                        </div>
                </div>                           
                
                <div class="row" style="background-color: #79d279; height: 4px; margin-top: 12px;">
                </div>                
                <!-- Проверка заявки -->
                <div class="row" style="margin-top: 12px;" >
                        <div class="col-md-1" >        
                        </div>
                        <div class="col-md-4"  >        
                            <el-tag    :type="search_result_status"  effect="dark" v-show="search_result_status_show"> {{ search_result_text }} </el-tag>
                        </div>
                        <div class="col-md-4" > 
                            Если вы уже зарегистрировали заявку, вы можете проверить ее статус по высланному на эл.почту коду      
                        </div>
                        <div class="col-md-1" >  
                            <el-input  placeholder="код" v-model="search_number" clearable> </el-input>      
                        </div>                        
                        <div class="col-md2" >        
                            <el-button  @click="search_request_status" type="info" round> Проверить </el-button>        
                        </div>
                        

                </div> 

            </div>
            <div class="col-md-2" style="background-color: #d9f2d9;">
            </div>            

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
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>   


