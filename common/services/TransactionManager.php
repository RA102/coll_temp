<?php

namespace common\services;

class TransactionManager
{
    /**
     * @param callable $function
     * @return mixed
     * @throws \Exception
     */
    public function execute(callable $function)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $result = call_user_func($function);
            $transaction->commit();
            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}