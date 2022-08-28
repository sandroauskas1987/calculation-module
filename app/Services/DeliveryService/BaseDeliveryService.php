<?php

namespace App\Services\DeliveryService;

use App\Models\TransportCompany;


class BaseDeliveryService
{
    /**
     * Идентификатор сервиса
     * @var int  // Fast = 1  Slow = 2
     */
    protected $service_id;

    /** 
     * Получение всех транспортных компаний по идентификатору сервиса
     */
    protected function getTransportCompaniesAndParams(): array
    {
        return TransportCompany::getParams($this->service_id);
    }

    /**
     * Расчет стоимости доставки
     */
    protected function calculatePrise(array $departure, array &$offer)
    {
        $number_of_kilometers = $this->getNumberOfKilometers($departure['sourceKladr'], $departure['targetKladr']);
        $offer['price'] = round($offer['price']  *  $number_of_kilometers, 2);
    }

    /**
     * метод расчета километров от КЛАДР откуда до КЛАДР куда  
     * @param string  $sourceKladr
     * @param string  $targetKladr
     */
    private function getNumberOfKilometers(string $sourceKladr, string  $targetKladr)
    {
        return rand(strlen($sourceKladr), strlen($targetKladr));
    }

}