<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Приемная комиссия',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Текушая комиссия', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Архив комиссий', 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => 'Заявления', 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => 'Абитуриенты', 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => 'Картотека',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Сотрудники', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Студенты', 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => 'Учебный процесс',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Группы', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Расписание', 'icon' => 'dashboard', 'url' => ['/']],
                            ['label' => 'Распределение', 'icon' => 'dashboard', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => 'Хозяйственная часть',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Здания', 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                    [
                        'label' => 'Настройки',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Специальности', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Предметы', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Учебный процесс', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Организация', 'icon' => 'file-code-o', 'url' => ['/']],
                            ['label' => 'Система рейтинга', 'icon' => 'file-code-o', 'url' => ['/']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
