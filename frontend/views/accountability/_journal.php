<?php

use common\helpers\ApplicationHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form frontend\models\forms\JournalForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $specialities common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Commissions');
$i = 1;
?>

<h5 class="text-center">
    <b>
        ЖУРНАЛ
        <br>
        регистрация заявлений абитуриентов,
        <br>
        поступающих в 2019 году
    </b>
</h5>

<table>
    <tr>
        <td>№№ п.п.</td>
        <td>Фамилия, имя, отчество</td>
        <td>Дата рождения</td>
        <td>ИИН</td>
        <td>Национальность</td>
        <td>Отметка о документе подтверждающем права на льготы при зачислении</td>
        <td>Нуждается в общежитие (да, нет)</td>
        <td>Язык обучения</td>
        <td>Учебный год</td>
        <td>Код специальности</td>
        <td>Название специальности</td>
        <td>Код квалификации</td>
        <td>Название квалификации</td>
        <td>Дата приема документов</td>
        <td>Образование (какое учебное заведение и когда окончил, его место нахождение). Для выпускников ПТШ указать на
            базе какой ступени школы они обучались в ПТШ
        </td>
        <td>Номер и дата выдачи документа об образовании</td>
        <td>Отметка о зачислении или отказе</td>
        <td>Отметка о возврате документов</td>
        <td>Адрес место жительства по прописке</td>
        <td>Форма обучения</td>
        <td>Должность получателя</td>
    </tr>
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
        <td>15</td>
        <td>16</td>
        <td>17</td>
        <td>18</td>
        <td>19</td>
        <td>20</td>
        <td>21</td>
    </tr>
    <?php
    /** @var \common\models\reception\AdmissionApplication $model */
    foreach ($dataProvider->getModels() as $model):
        ?>
        <tr>
            <td><?= $model->id;
                $i++ ?></td>
            <td><?= $model->student->getFullName() ?></td>
            <td><?= $model->student->birth_date ?></td>
            <td><?= $model->student->iin ?></td>
            <td><?= $model->student->nationality->name ?></td>
            <td></td> <!-- Отметка о документе подтверждающем права на льготы при зачислении -->
            <td></td> <!-- Нуждается в общежитие (да, нет) -->
            <td><?= $model->properties['language'] ?? '' ?></td>
            <td></td> <!-- Учебный год -->
            <td><?= $specialities[$model->properties['speciality_id']]->parent->code ?? '' ?></td>
            <!-- Код специальности -->
            <td><?= $specialities[$model->properties['speciality_id']]->parent->caption_current ?? '' ?></td>
            <!-- Название специальности -->
            <td><?= $specialities[$model->properties['speciality_id']]->code ?? '' ?></td>
            <!-- Код квалификации -->
            <td><?= $specialities[$model->properties['speciality_id']]->caption_current ?? '' ?></td>
            <!-- Название квалификации -->
            <td><?= $model->properties['application_date'] ?? '' ?></td>
            <td></td>
            <td></td>
            <td><?= ApplicationHelper::$list[$model->status] ?></td>
            <td></td>
            <td><?= $model->student->birth_place ?></td>
            <td><?= \common\helpers\EducationHelper::getEducationFormTypes()[$model->properties['education_form']] ?></td>
            <!--        <td>-->
            <? //= \common\helpers\EducationHelper::getPaymentFormTypes()[$model->properties['education_pay_form']]
            ?><!--</td>-->
            <td></td>
        </tr>
    <?php endforeach; ?>
</table>