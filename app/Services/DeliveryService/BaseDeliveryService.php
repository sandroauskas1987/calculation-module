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
     * @param string  $sourceKladr  КЛАДР откуда
     * @param string  $targetKladr  КЛАДР куда 
     * @param float   $offer_price  стоимость одного километра доставки
     */
    public function calculatePrise(string $sourceKladr, string  $targetKladr,float &$offer_price)
    {
        $offer_price = $this->getAmount($this->getNumberOfKilometers($sourceKladr, $targetKladr), $offer_price);
    }

    /**
     * Получить сумму доставки
     */
    public function getAmount (int $number_of_kilometers, float $offer_price):float
    {
        return round($offer_price  *  $number_of_kilometers, 2);
    }

    /**
     * имитация метода расчета километров
     * @param string  $sourceKladr  КЛАДР откуда
     * @param string  $targetKladr  КЛАДР куда 
     */
    public function getNumberOfKilometers(string $sourceKladr, string  $targetKladr):int
    {
        return rand(strlen($sourceKladr), strlen($targetKladr));
    }

}