<?php

namespace common\services;

class TransactionManager
{
    /**
     * @param callable $function
     * @throws \yii\db\Exception
     */
    public function execute(callable $function)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            call_user_func($function);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}