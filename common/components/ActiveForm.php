<?php

namespace common\components;

use yii\helpers\Html;

/**
 * Виджет формы
 * Для перезагрузки формы без валидации на элемент вешается
 * класс class="active-form-refresh-control"
 * Работает на событие change
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    public static $refreshParam = 'refresh-form';

    public function run()
    {
        $content = ob_get_clean();
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo Html::hiddenInput(static::$refreshParam, null, ['class' => 'active-form-refresh-value']);

        echo $content;

        if ($this->enableClientScript) {
            $this->registerClientScript();
        }

        echo Html::endForm();
    }

    public function registerClientScript()
    {
        parent::registerClientScript();
        $js = <<<JS
            $(document).off('change', '.active-form-refresh-control');
            $(document).on('change', '.active-form-refresh-control', function(event) {
                refreshActiveForm($(this));
            });  
                
            function refreshActiveForm(object) {
                var form = object.closest('form');
                form.find('.active-form-refresh-value').val('refresh');
                object.closest('.active-form-dependent-container').nextAll().remove();
                form.submit();
            }
JS;
        $this->getView()->registerJs($js);
    }
}