<?php

namespace App\Services\DeliveryService;

use App\Services\CurlService;

use function PHPUnit\Framework\isNull;

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
    public function getOffers($departure): array
    {
        $offers = [];
        foreach ($this->getTransportCompaniesAndParams() as $value) {
            $departure = array_merge($value['params'], $departure);

            $serviceRes = CurlService::send($value['base_url'], $departure, 'slow'); // запрос цены и даты доставки от сервиса транспортной компании (предполагается что "price"  - цена за 1 км)

            $this->formattingResponse($serviceRes); // приведение к формату

            if (!isNull($serviceRes['price']))
            $this->calculatePrise($departure['sourceKladr'], $departure['sourceKladr'], $serviceRes['price']); // расчет стоимости за каждый километр доставки

            $serviceRes['company'] = $value['Company_name'];

            $offers[] = $serviceRes;
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
