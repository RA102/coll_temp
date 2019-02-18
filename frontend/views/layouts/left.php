<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => Yii::t('app','Приемная комиссия'),
                        'icon' => 'far fa-id-card',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Текушая комиссия'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Архив комиссий'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Заявления'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Абитуриенты'), 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Картотека'),
                        'icon' => 'far fa-list-alt',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Сотрудники'), 'icon' => 'file-code-o', 'url' => ['/employee']],
                            ['label' => Yii::t('app','Учащиеся'), 'icon' => 'dashboard', 'url' => ['/student/index']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Учебный процесс'),
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Группы'), 'icon' => 'file-code-o', 'url' => ['/group']],
                            ['label' => Yii::t('app','Расписание'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Распределение'), 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Хозяйственная часть'),
                        'icon' => 'far fa-building',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Здания'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Настройки'),
                        'icon' => 'cog',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Специальности'), 'icon' => 'file-code-o', 'url' => ['/speciality']],
                            ['label' => Yii::t('app','Предметы'), 'icon' => 'file-code-o', 'url' => ['/institution-discipline']],
                            ['label' => Yii::t('app','Курсы'), 'icon' => 'file-code-o', 'url' => ['/course/index']],
                            ['label' => Yii::t('app','Учебный процесс'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Организация'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Система рейтинга'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>

</aside>
