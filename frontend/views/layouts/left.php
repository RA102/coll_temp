<aside class="main-sidebar">

    <section class="sidebar">
        <?php
        $commissionService = new \common\services\reception\CommissionService;
        $person = \Yii::$app->user->identity;
        $activeCommission = $commissionService->getActiveInstitutionCommission($person->institution);
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items'   => [
                    [
                        'label' => Yii::t('app', 'Все колледжи'),
                        'icon'  => 'far fa-archway',
                        'url'   => '/institution/all',
                        'visible' => $person->isAdmin() && $person->institutionAdvanced(),
                    ],
                    [
                        'label' => Yii::t('app', 'Selection committee'),
                        'icon'  => 'far fa-id-card',
                        'url'   => '#',
                        'visible' => $person->isAdmin() || $person->isHr() || $person->isDirector() || $person->isAdmissionSpecialist(),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Текушая комиссия'),
                                'icon'  => 'file-code-o',
                                'url'   => $activeCommission ? [
                                    'commission/view',
                                    'id' => $activeCommission->id
                                ] : ['/commission/current']
                            ],
                            [
                                'label' => Yii::t('app', 'Архив комиссий'),
                                'icon'  => 'dashboard',
                                'url'   => ['/commission/index']
                            ],
                            [
                                'label' => Yii::t('app', 'Заявления'),
                                'icon'  => 'dashboard',
                                'url'   => ['/admission-application/index']
                            ],
                            [
                                'label' => Yii::t('app', 'Entrants'),
                                'icon'  => 'dashboard',
                                'url'   => ['/entrant/index']
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Управление организацией'),
                        'icon'  => 'far fa-archway',
                        'url'   => '#',
                        'visible' => $person->isAdmin() || $person->isHr() || $person->isDirector() || $person->isChairman() || $person->isDirectorDeputyAcademic() || $person->isDirectorDeputyEducation() || $person->isDirectorDeputyIndustrial() || $person->isDirectorDeputyMethodist() || $person->isDirectorDeputyEconomic() || $person->isManager() || $person->isSocialTeacher() || $person->isPsychologist(),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Картотека'),
                                'icon'  => 'far fa-list-alt',
                                'url'   => '#',
                                'visible' => !$person->isChairman() && !$person->isDirectorDeputyEducation() && !$person->isDirectorDeputyIndustrial() && !$person->isDirectorDeputyEconomic() && !$person->isManager() && !$person->isSocialTeacher() && !$person->isSocialTeacher() && !$person->isPsychologist(),
                                'items' => [
                                    [
                                        'label' => Yii::t('app', 'Employees'), 
                                        'icon' => 'file-code-o', 
                                        'url' => ['/employee'],
                                        //'visible' => !$person->isTeacher(),
                                    ],
                                    [
                                        'label' => Yii::t('app', 'Students'), 
                                        'icon' => 'dashboard', 
                                        'url' => ['/student/index'],
                                    ],
                                ],
                            ],
                            [
                                'label' => Yii::t('app','Хозяйственная часть'),
                                'icon' => 'far fa-building',
                                'url' => '#',
                                'visible' => !$person->isHr() && !$person->isChairman() && !$person->isDirectorDeputyAcademic() && !$person->isDirectorDeputyEducation() && !$person->isDirectorDeputyIndustrial() && !$person->isDirectorDeputyMethodist() && !$person->isManager() && !$person->isSocialTeacher() && !$person->isPsychologist(),
                                'items' => [
                                    [
                                        'label' => Yii::t('app', 'Аудитории'),
                                        'icon'  => 'file-code-o',
                                        'url'   => ['/classroom']
                                    ],
                                ],
                            ],
                            [
                                'label' => Yii::t('app','Приказы'),
                                'icon' => 'far fa-building',
                                'url' => '/order/index',
                                'visible' => !$person->isDirectorDeputyEconomic() && $person->institutionAdvanced(),
                            ],
                            [
                                'label' => Yii::t('app','Отчеты'),
                                'icon' => 'far fa-building',
                                'url' => '/stats/01',
                                'visible' => !$person->isDirectorDeputyEconomic() && $person->institutionAdvanced(),
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Учебный процесс'),
                        'icon'  => 'book',
                        'url'   => '#',
                        'visible' => $person->isAdmin() || $person->isTeacher() || $person->isDirector() || $person->isDirectorDeputyAcademic() || $person->isDirectorDeputyEducation() || $person->isDirectorDeputyIndustrial() || $person->isManager() || $person->isSocialTeacher() || $person->isPsychologist(),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Планирование учебного процесса'),
                                'icon'  => 'dashboard',
                                'url'   => ['/plan/index'],
                                'visible' => !$person->isSocialTeacher() && !$person->isPsychologist() && $person->institutionAdvanced(),
                                'items' => [
                                    [
                                        'label' => 'Обязательные дисциплины',
                                        'url'   => ['/plan/required'],
                                    ],
                                    [
                                        'label' => 'Дисциплины по выбору',
                                        'url'   => ['/plan/optional'],
                                    ],
                                    [
                                        'label' => 'Факультативные курсы',
                                        'url'   => ['/plan/facultative'],
                                    ],
                                    [
                                        'label' => 'Практика',
                                        'url' => ['/plan/practice'],
                                    ],
                                    [
                                        'label' => 'Контроль знаний',
                                        'url' => ['/plan/exams'],
                                    ],
                                    [
                                        'label' => 'Профессиональная практика',
                                        'url' => ['/plan/professional-practice'],
                                    ],
                                ],
                            ],
                            [
                                'label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'),
                                'icon'  => 'dashboard',
                                'visible' => !$person->isSocialTeacher() && !$person->isPsychologist() && $person->institutionAdvanced(),
                                'url'   => ['/personnel/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Расписание'),
                                'icon'  => 'dashboard',
                                'url'   => ['/lesson/index'],
                                'visible' => $person->isAdmin(),
                            ],
                            [
                                'label' => Yii::t('app', 'Электронный журнал'),
                                'icon'  => 'dashboard',
                                'url'   => ['/journal/index'],
                                'visible' => $person->isAdmin(),
                            ],
                            /*[
                                'label' => Yii::t('app', 'Электронный сессия'),
                                'icon'  => 'dashboard',
                                'url'   => ['/session/index']
                            ],*/
                            [
                                'label' => Yii::t('app', 'Группы'), 
                                'icon' => 'file-code-o', 
                                'url' => ['/group'],
                            ],
                            [
                                'label' => Yii::t('app', 'Распределение'),
                                'icon'  => 'dashboard',
                                'url'   => ['/group/allocate'],
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Настройки'),
                        'icon'  => 'cog',
                        'url'   => '#',
                        'visible' => $person->isAdmin() || $person->isDirector(),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Специальности'),
                                'icon'  => 'file-code-o',
                                'url'   => ['/speciality']
                            ],
                            [
                                'label' => Yii::t('app', 'Дисциплины'),
                                'icon'  => 'file-code-o',
                                'url'   => ['/institution-discipline']
                            ],
                            [
                                'label' => Yii::t('app', 'Курсы'), 
                                'icon' => 'file-code-o', 
                                'url' => ['/course/index']
                            ],
                            [
                                'label' => Yii::t('app', 'Учебная практика'), 
                                'icon' => 'file-code-o', 
                                'url' => ['/practice/index'],
                                'visible' => $person->institutionAdvanced(),
                            ],
                            [
                                'label' => Yii::t('app', 'Профессиональная практика'), 
                                'icon' => 'file-code-o', 
                                'url' => ['/professional-practice/index'],
                                'visible' => $person->institutionAdvanced(),
                            ],
//                            ['label' => Yii::t('app','Учебный процесс'), 'icon' => 'file-code-o', 'url' => ['/']],
                            [
                                'label' => Yii::t('app', 'Организация'),
                                'icon'  => 'file-code-o',
                                'url'   => ['/institution']
                            ],
                            
//                            ['label' => Yii::t('app','Система рейтинга'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>

</aside>
