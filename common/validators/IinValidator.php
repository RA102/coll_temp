<?php

namespace common\validators;

use yii\validators\Validator;

class IinValidator extends Validator
{
    const IIN_PATTERN = "/^\d{12}$/";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = \Yii::t('app', 'Некорректный ИИН');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        if (!is_string($value)) {
            $this->addError($model, $attribute, $this->message);

            return;
        }

        if (preg_match(self::IIN_PATTERN, $value, $matches) && $this->validateChecksum($value)) {
            return;
        }

        $this->addError($model, $attribute, $this->message);
    }

    /**
     * @see https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D0%B4%D0%B8%D0%B2%D0%B8%D0%B4%D1%83%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%B8%D0%B4%D0%B5%D0%BD%D1%82%D0%B8%D1%84%D0%B8%D0%BA%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D1%8B%D0%B9_%D0%BD%D0%BE%D0%BC%D0%B5%D1%80
     * @param string $iin
     * @return bool
     */
    private function validateChecksum(string $iin): bool
    {
        $digits = str_split(substr($iin, 0, 11));
        $actualChecksum = intval(substr($iin, 11, 1));

        $passOneChecksum =
            array_sum(
                array_map(function (string $digit, int $idx) {
                    $digitWeight = $idx + 1;
                    return intval($digit) * $digitWeight;
                }, $digits, array_keys($digits))
            ) % 11;
        if ($passOneChecksum !== 10 && $passOneChecksum === $actualChecksum) {
            return true;
        }

        $passTwoChecksum =
            array_sum(
                array_map(function (string $digit, int $idx) {
                    $digitWeight = (($idx + 2) % 11) + 1;
                    return intval($digit) * $digitWeight;
                }, $digits, array_keys($digits))
            ) % 11;
        if ($passTwoChecksum !== 10 && $passTwoChecksum === $actualChecksum) {
            return true;
        }

        return false;
    }

}