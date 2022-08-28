<?php

namespace App\Services\DeliveryService;

use App\Services\CurlService;

/**
 * Служба расчета медленных доставок, работает с поддерживающими медленные доставки транспортными компаниями
 * Class SlowDelivery
 * @package App\Services
 */
class SlowDeliveryService extends BaseDeliveryService
{
    protected const BASE_PRICE = '150';

    function __construct()
    {
        $this->service_id = 2 ;
    }

    /** 
     * Запрос стоимости и сроков доставки в контексте списка транспортных компаний
     */
    public function getOffers(array $departure): array
    {
        $offers = [];
        foreach ($this->getTransportCompaniesAndParams() as $value) {
            $departure = array_merge($value['params'], $departure);
            $res = CurlService::send($value['base_url'],$departure, [], [], 'slow');    // запрос цены и даты доставки от сервиса транспортной компании (предполагается что "price"  - цена за 1 км)
            $this->formattingResponse($res);                                            // приведение к единому формату
            $this->calculatePrise($departure, $res);                                    // расчет стоимости за каждый километр доставки
            $res['Company'] = $value['Company_name'];
            $offers[] = $res;
        }
        return $offers;
    }

    /** 
     *  Форматирование ответа
     */
    protected function formattingResponse(&$response)
    {
        if (isset($response['date'])) {
            $response['date'] = is_numeric($response['date']) ? date('Y-m-d', $_SERVER['REQUEST_TIME'] + 3600 * 24 * $response['date']) : $response['date'];
        }
        if (isset($response['coefficient'])) {
            $response['price'] = round(self::BASE_PRICE * $response['coefficient'], 2);
            unset($response['coefficient']);
        }
    }
}
