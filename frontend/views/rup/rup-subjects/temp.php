<?php

$dataProviderSubject = new RupSubjects;
        $templates = RupSubjects::find()->Where(['id_sub_block' => $id])->all();
        $listData = ArrayHelper::map($templates, 'id', 'name');

        return $this->renderAjax('form-update', [
            'dataProviderSubject' => $dataProviderSubject,
            'templates' => $templates,
            'listData' => $listData,
        ]);