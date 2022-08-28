<?php
namespace App\Lib;

/**
 * Class ErMessages Возможные ошибки сервиса
 * @package App\Lib
 */
final class ErMessages
{

    /**
     * @OA\Schema(schema="response_error",
     *   title="Response-Error",
     *   @OA\Property(
     *      property="errors",
     *      format="array",
     *      type="array",
     *      @OA\Items(
     *         type="object",
     *         @OA\Property(
     *            property="code",
     *            type="integer",
     *            example=92
     *          ),
     *          @OA\Property(
     *             property="message",
     *             type="string",
     *             example="Сообщение об ошибке"
     *          )
     *      )
     *   ),
     *   @OA\Property(property="status", type="boolean", example=false)
     * )
     *
     **/

    /**
     * Массив ошибок
     * @return array[]
     */
    private static function catalog()
    {
        return [
            'none' => ['code' => 10, 'message' => 'Неизвестная ошибка'],
            //401
            //403
            //404 Not found
            'NotFound' => ['code' => 41, 'message' => 'Не найдено'],
            //422
            'notArgs' => ['code' => 98, 'message' => 'Неверные аргументы запроса.'],
            //409
        ];
    }


    /**
     * Получить ошибку по кодовому наименованию
     * @param $mess
     * @param array $param
     * @return array|string|string[]
     */
    public static function get($mess, $param = [])
    {
        $messages = self::catalog();
        if (is_string($mess) && isset($messages[$mess])) {
            if (is_array($param) && count($param) > 0) {
                $ms = $messages[$mess];
                foreach ($param as $i => $p) {
                    $ms = str_replace('%' . ($i + 1), $p, $ms);
                }
                return $ms;
            }
            return $messages[$mess];
        } else {
            return ['code' => 500, 'message' => is_array($mess) ? implode(PHP_EOL, $mess) : $mess];
        }
    }

    /**
     * Вызвать исключительную ситуацию с ошибкой
     * @param $mess
     * @param array $param
     * @throws \Exception
     */
    public static function throwException($mess, $param = [])
    {
        $messages = self::get($mess, $param);
        $code = self::getCodeResponse($messages);
        throw new \Exception($messages['message'], $code);
    }


    /**
     * Определение Http Code error на основании внутреннему коду ошибки
     * @param $code
     * @return int
     */
    private static function code($code)
    {
        switch (true) {
            case in_array($code, [71, 72]):
                return 401;
            case in_array($code, [41,42]):
                return 404;
            case in_array($code, [75, 76, 77, 78, 85, 86, 87, 88]):
                return 403;
            case $code == 90:
                return 405;
            case (int)$code == 409:
                return 409;
            case $code > 91:
                return 422;
            default:
                return 400;
        }
    }

    /**
     * Получить Http Code на основании массива ответа
     * @param $data
     * @return int
     */
    public static function getCodeResponse($data)
    {
        if(isset($data['errors'])){
            if (isset($data['errors'][0]) && isset($data['errors'][0]['code'])){
                return self::code($data['errors'][0]['code']);
            }else
                return 400;
        }else if (isset($data['status']) && $data['status']){
            return 200;
        }else if (isset($data['code'])) {
            return self::code($data['code']);
        }else{
            return 500;
        }

    }

    /**
     * Используемые Http Code
     * @return int[]
     */
    public static function getUseHttpCode(){
        return [
            500,
            501,
            503,
            507,
            511,
            400,
            401,
            403,
            404,
            405,
            409,
            421,
            422,
            426,
            429,
            302
        ];
    }
}
