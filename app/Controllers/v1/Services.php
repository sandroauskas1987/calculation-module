<?php

namespace App\Controllers\v1;

use App\Controllers\InitBaseController;
use Psr\Container\ContainerInterface;
use App\Services\DeliveryService\FastDeliveryService;
use App\Services\DeliveryService\SlowDeliveryService;
use Exception;
use Slim\Http\Response;
use Slim\Http\Request;

/**
 * Контроллер работы со службами доставки
 * Class Services
 * @package App\Controllers\v1
 */

/**
 * @OA\Get(
 *   path="/services/fast",
 *   tags={"Services"},
 *   operationId="Fast",
 *   summary="Получить для набора отправлений стоимость и сроки доставки в контексте списка транспортных компаний. (Служба быстрой доставки)",
 *   description="Получить для набора отправлений стоимость и сроки доставки в контексте списка транспортных компаний. (Служба быстрой доставки)",
 *   @OA\Parameter(
 *         name="sourceKladr",
 *         in="query",
 *         description="Кладр откуда везем",
 *         required=true,
 *         @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *         name="targetKladr",
 *         in="query",
 *         description="Кладр куда везем",
 *         required=true,
 *         @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *         name="weight",
 *         in="query",
 *         description="Вес",
 *         required=true,
 *         @OA\Schema(type="float")
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="OK",
 *     content={
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                   type="array",
 *                   @OA\Items(
 *                       @OA\Property(
 *                           property="departure",
 *                           type="string",
 *                           description="Отправление",
 *                           example="Москва римская => Москва калужская [5 kg]"
 *                       ),
 *                       @OA\Property(
 *                           property="offers",
 *                           type="array", 
 *                               @OA\Items(
 *                                 @OA\Property(
 *                                    property="Company",
 *                                    type="string",
 *                                    description="Транспортная компания",
 *                                    example="delivery company Kolin"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="date",
 *                                    type="date",
 *                                    description="дата доставки",
 *                                    example="2022-09-13"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="price",
 *                                    type="float",
 *                                    description="Сумма доставки",
 *                                    example="10090.5"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="error",
 *                                    type="string",
 *                                    description="Сообщение об ошибке от сервиса ТК",
 *                                    example="Сервис временно не доступен"
 *                                ),
 *                            )
 *                        )
 *                    )
 *                )
 *            )
 *         }
 *      )      
 *   )
 * )
 * 
 * @OA\Get(
 *   path="/services/slow",
 *   tags={"Services"},
 *   operationId="Slow",
 *   summary="Получить для набора отправлений стоимость и сроки доставки в контексте списка транспортных компаний. (Служба медленной доставки)",
 *   description="Получить для набора отправлений стоимость и сроки доставки в контексте списка транспортных компаний. (Служба медленной доставки)",
 *   @OA\Parameter(
 *         name="sourceKladr",
 *         in="query",
 *         description="Кладр откуда везем",
 *         required=true,
 *         @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *         name="targetKladr",
 *         in="query",
 *         description="Кладр куда везем",
 *         required=true,
 *         @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *         name="weight",
 *         in="query",
 *         description="12",
 *         required=true,
 *         @OA\Schema(type="float")
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="OK",
 *     content={
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                   type="array",
 *                   @OA\Items(
 *                       @OA\Property(
 *                           property="departure",
 *                           type="string",
 *                           description="Отправление",
 *                           example="Москва римская => Москва калужская [5 kg]"
 *                       ),
 *                       @OA\Property(
 *                           property="offers",
 *                           type="array", 
 *                               @OA\Items(
 *                                 @OA\Property(
 *                                    property="Company",
 *                                    type="string",
 *                                    description="Транспортная компания",
 *                                    example="delivery company Kolin"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="date",
 *                                    type="date",
 *                                    description="дата доставки",
 *                                    example="2022-09-13"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="price",
 *                                    type="float",
 *                                    description="Сумма доставки",
 *                                    example="10090.5"
 *                                 ),
 *                                 @OA\Property(
 *                                    property="error",
 *                                    type="string",
 *                                    description="Сообщение об ошибке от сервиса ТК",
 *                                    example="Сервис временно не доступен"
 *                                ),
 *                            )
 *                        )
 *                    )
 *                )
 *            )
 *         }
 *      )      
 *   )
 * )
 **/


class Services extends InitBaseController
{
    /**
     * @var FastDeliveryService
     */
    private static $fastDelivery;
    /**
     * @var FastDeliveryService
     */
    private static $slowDelivery;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        self::$fastDelivery = new FastDeliveryService();
        self::$slowDelivery = new SlowDeliveryService();
    }

    /**
     * Правила валидации
     * @var array
     */
    protected $rules = [
        'sourceKladr' => 'required|string|max:255',
        'targetKladr' => 'required|string|max:255',
        'weight' => 'required|numeric'
    ];

    /** 
     * валидация
     */
    protected function checkValidate(Request $request, Response $response)
    {
        $request_params_arr = $this->getParsedRequestData($request);
        foreach ($request_params_arr as $request_params) {
            if (!is_array($request_params)) {
                \App\Lib\ErMessages::throwException('notArgs');
            } elseif (!$this->validate($request_params, $this->rules)) {
                return $this->response($response);
            }
        }
    }

    /**
     * Быстрая доставка
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws Exception
     */
    public function Fast(Request $request, Response $response)
    {
        $this->checkValidate($request, $response);
        try {
            $result_list = [];
            foreach ($this->getParsedRequestData($request) as $key => $request_params) {
                $result_list[$key]['departure'] = $request_params['sourceKladr'] . ' =>  ' . $request_params['targetKladr'] . ' [' . $request_params['weight'] . ' kg]';
                $result_list[$key]['offers'] = self::$fastDelivery->getOffers($request_params);
            }
            $this->setData($result_list);
        } catch (Exception $e) {
            $this->setError($e);
        }
        return $this->response($response);
    }

    /**
     * Медленная доставка
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws Exception
     */
    public function Slow(Request $request, Response $response)
    {
        $this->checkValidate($request, $response);
        try {
            $result_list = [];
            foreach ($this->getParsedRequestData($request) as $key => $request_params) {
                $result_list[$key]['departure'] = $request_params['sourceKladr'] . ' =>  ' . $request_params['targetKladr'] . ' [' . $request_params['weight'] . ' kg]';
                $result_list[$key]['offers'] = self::$slowDelivery->getOffers($request_params);
            }
            $this->setData($result_list);
        } catch (Exception $e) {
            $this->setError($e);
        }
        return $this->response($response);
    }
}
