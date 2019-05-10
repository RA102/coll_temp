<?php

namespace common\services\reception;

use common\models\reception\AdmissionProtocol;
use common\models\reception\Commission;
use common\services\exceptions\DomainException;
use frontend\models\forms\AdmissionProtocolForm;
use frontend\models\reception\admission_protocol\ProtocolIssueForm;

class AdmissionProtocolService
{
    /**
     * @param Commission $commission
     * @param AdmissionProtocolForm $admissionProtocolForm
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function create(Commission $commission, AdmissionProtocolForm $admissionProtocolForm): AdmissionProtocol
    {
        $admissionProtocol = AdmissionProtocol::add(
            $commission->id,
            $admissionProtocolForm->number,
            $admissionProtocolForm->completion_date,
            $admissionProtocolForm->commission_members,
            $admissionProtocolForm->agendas
        );

        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }

    /**
     * @param AdmissionProtocol $admissionProtocol
     * @param ProtocolIssueForm $protocolIssueForm
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function addIssue(AdmissionProtocol $admissionProtocol, ProtocolIssueForm $protocolIssueForm)
    {
        if (!$admissionProtocol->isCreated()) {
            throw new DomainException(
                'Forbidden',
                'Данное действие недоступно'
            );
        }
        $admissionProtocol->issues = array_merge(
            $admissionProtocol->issues ?? [],
            [$protocolIssueForm->getAttributes()]
        );

        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }

    /**
     * @param AdmissionProtocol $admissionProtocol
     * @param AdmissionProtocolForm $admissionProtocolForm
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function update(AdmissionProtocol $admissionProtocol, AdmissionProtocolForm $admissionProtocolForm)
    {
        if (!$admissionProtocol->isCreated()) {
            throw new DomainException(
                'Forbidden',
                'Данное действие недоступно'
            );
        }
        $admissionProtocol->setAttributes($admissionProtocolForm->getAttributes());

        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }

    /**
     * @param AdmissionProtocol $admissionProtocol
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function close(AdmissionProtocol $admissionProtocol)
    {
        $admissionProtocol->status = AdmissionProtocol::STATUS_CLOSED;

        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }

    /**
     * @param AdmissionProtocol $admissionProtocol
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function delete(AdmissionProtocol $admissionProtocol)
    {
        $admissionProtocol->delete();

        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }

    /**
     * @param AdmissionProtocol $admissionProtocol
     * @param int $key
     * @return AdmissionProtocol
     * @throws DomainException
     */
    public function deleteIssue(AdmissionProtocol $admissionProtocol, int $key)
    {
        if ($key > sizeof($admissionProtocol->issues ?? [])) {
            throw new DomainException(
                'Protocol issue does not exist',
                'Заявка с таким номер отсутвутсвует'
            );
        }
        if (!$admissionProtocol->isCreated()) {
            throw new DomainException(
                'Forbidden',
                'Данное действие недоступно'
            );
        }

        $admissionProtocol->issues = array_filter($admissionProtocol->issues, function (int $index) use ($key) {
            return $index !== $key;
        }, ARRAY_FILTER_USE_KEY);


        if (!$admissionProtocol->save()) {
            throw new DomainException(
                'Admission protocol saving failed',
                current($admissionProtocol->firstErrors)
            );
        }

        return $admissionProtocol;
    }
}