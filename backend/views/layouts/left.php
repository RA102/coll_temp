<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => Yii::t('app','Пользователи'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Список'), 'icon' => 'file-code-o', 'url' => ['/person']],
                            ['label' => Yii::t('app','Роли'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Должности'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Социальные статусы'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Управление клонами'), 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Организации'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Заявки'), 'icon' => 'file-code-o', 'url' => ['/application']],
                            ['label' => Yii::t('app','Список'), 'icon' => 'dashboard', 'url' => ['/institution']],
                            ['label' => Yii::t('app','Типы'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы помещений'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Группы'), 'icon' => 'dashboard', 'url' => ['/group/index']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Геолокация'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Страны'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Административные еденицы'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Улицы'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы улиц'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Территории'), 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Учебный процесс'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Специальности'), 'icon' => 'file-code-o', 'url' => ['/speciality']],
                            ['label' => Yii::t('app','Профессии'), 'icon' => 'dashboard', 'url' => ['/']],
                            //['label' => Yii::t('app','Предметы'), 'icon' => 'dashboard', 'url' => ['/discipline/index']],
                            ['label' => Yii::t('app','Системы оценивания'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Темы уроков'), 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы уроков'), 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Документы'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Шаблоны документов'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы документов'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы файлов'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Справочники'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Ученые степени'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Причины'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Образовательные формы'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Организационно-правовые формы'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Награды'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Языки'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Национальности'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Олимпиады'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы публикаций'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы оборудования'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Типы событий'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Группы дошкольных организаций'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Библиотека'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Книги'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Издательства'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Уведомления'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Оповещения'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Электронные письма'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app','Система'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app','Настройка'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Словари'), 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => Yii::t('app','Выгрузка улиц'), 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>

</aside>
