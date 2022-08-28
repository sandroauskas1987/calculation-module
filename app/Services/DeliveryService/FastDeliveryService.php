<?php

namespace App\Services\DeliveryService;

use App\Services\CurlService;

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
     */
    public function getOffers($departure): array
    {
        $offers = [];
        foreach ($this->getTransportCompaniesAndParams() as $value) {
            $departure = array_merge($value['params'],$departure);
            $res = CurlService::send($value['base_url'], $value['params'], [], [], 'fast');// запрос цены и даты доставки от сервиса транспортной компании (предполагается что "price"  - цена за 1 км)
            $this->calculatePrise($departure,$res); // расчет стоимости за каждый километр доставки
            $res['Company']= $value['Company_name'];
            $offers[] = $res;
        }
        return $offers;
    }

}
