<?php

namespace App\Services;

class CurlService
{
    /** 
     * Запрос данных из сервиса транспортной компании
     * @param string  $service_type ['slow'/'fast']
     */
    public static function send($url, $params = [], $postFields = [], $headers = [],string $service_type)
    {
        $result = ['data' => [], 'error' => null];
        try {
            if (!rand(0, 7)) {// рандомная эмуляция запроса к сервису транспортной компании
                $link = $url . '?' . http_build_query($params);

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_URL => $link,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => !empty($postFields),
                    CURLOPT_POSTFIELDS => json_encode($postFields),
                ]);

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                $result = $response;
                if ($httpCode !== 200) {
                    $result['price'] = null;
                    $result['date'] = null;
                    $result['error'] = 'Сервис временно не доступен';
                }
            } else {
                $result = self::arbitraryDataSet($service_type);
            }
        } catch (\Throwable $e) {
            $result['error'] = json_encode($e);
        }
        return  $result;
    }

    /** 
     * Генерация случайных наборов ответов от транспортных компаний (для примера)
     * @param string  $service_type ['slow'/'fast']
     */
    protected static function arbitraryDataSet($service_type): array
    {
        $random = fn ($min = 1, $max = 1000, $mul = 1000000) => round(mt_rand($min * $mul, $max * $mul) / $mul,2);
        if ($service_type === 'slow') {
            return [
                "coefficient" => $random(1, 3),
                "date" => rand(10, 30),
                "error" => ''
            ];
        } elseif($service_type === 'fast') {
            return [
                "price" => $random(1,5000),
                "date" => date('Y-m-d', $_SERVER['REQUEST_TIME']+ 3600 * 24 * rand(1, 10)),
                "error" => ''
            ];
        }
    }
}
