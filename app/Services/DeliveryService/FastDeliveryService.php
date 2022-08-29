<?php

namespace App\Services\DeliveryService;

use App\Services\CurlService;

use function PHPUnit\Framework\isNull;

/**
 * Служба расчета быстрых доставок, работает с поддерживающими быстрые доставки транспортными компаниями
 * Class FastDeliveryService
 * @package App\Services
 */
class FastDeliveryService extends BaseDeliveryService
{
    function __construct()
    {
        $this->service_id = 1;
    }

    /** 
     * Запрос стоимости и сроков доставки в контексте списка транспортных компаний
     * @param array  $departure  Массив параметров отправления
     */
    public function getOffers($departure): array
    {
        foreach ($this->getTransportCompaniesAndParams() as $value) {
            $departure = array_merge($value['params'],$departure);
            
            $serviceRes = CurlService::send($value['base_url'], $departure,'fast'); // запрос цены и даты доставки от сервиса транспортной компании (предполагается что "price"  - цена за 1 км)
            
            if(!isNull($serviceRes['price']))
            $this->calculatePrise($departure['sourceKladr'], $departure['sourceKladr'], $serviceRes['price']); // расчет стоимости за каждый километр доставки

            $serviceRes['company']= $value['Company_name'];

            $offers[] = $serviceRes;
        }
        return $offers;
    }
}