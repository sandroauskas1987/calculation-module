<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Services\ValidatorService;

/**
 * @OA\Info(
 *     version="v1",
 *     title="Описание API модуля расчета стоимости доставки",
 *     description="подсистема расчетов",
 *     @OA\Contact(
 *          name = "Разработчик",
 *          email = "alex_shok_san@mail.ru"
 *     )
 * ) 
 * 
 * @OA\Server(
 *     url = "https://test1.ru",
 *     description = "Test server"
 *  )
 */


class InitBaseController
{


    protected $ci;

    protected $out = [];
    /**
     * Запрос параметра поиска
     * @var string
     */
    protected $search = null;
    /**
     * Массив полей для поиска параметра Search
     * @var array
     */
    protected $search_fields = [];
    /**
     * @var ValidatorService
     */
    protected $validator;


    /**
     * InitBaseController constructor.
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->ci = $container;
        $this->validator = $container->get('validator');
    }

    /**
     * Отправка результата
     * @param Response $response
     * @return Response
     */
    public function response(Response $response)
    {
        return $response->withJson($this->out);
    }

    /**
     * Установить данные для вывода при успешном выполнении
     * @param $data
     */
    public function setData($data)
    {
        if (!isset($this->out['errors'])) {
            $this->out = $data;
        }
    }

    /**
     * Добавить ошибку
     * @param $message
     */
    public function setError($message)
    {
        $this->out['errors'] = $message;
    }

    /**
     * Удаление с Request с параметра Body параметров которые не находятся в массиве $fields
     * @param Request $request
     * @param array $fields
     * @return Request
     */
    public function RequestBodyClean(Request $request, array $fields): Request
    {
        $requestBody = $request->getParsedBody();
        foreach ($requestBody as $name => $v) {
            if (!in_array($name, $fields)) unset($requestBody[$name]);
        }
        return $request->withParsedBody($requestBody);
    }

    /**
     * Проверка в RequestBody наличие всех обязательных параметров указанных в массиве $fields
     * Выводит наименование параметров которых нет в запросе.
     * @param Request $request
     * @param array $fields
     * @return null|array
     */
    public function isNotBodyRequiredParams(Request $request, array $fields)
    {
        $result = [];
        $requestBody = $request->getParsedBody();
        foreach ($fields as $name) {
            if (!isset($requestBody[$name])) array_push($result, $name);
        }
        return $result;
    }

    protected function getParsedRequestData(Request $request): array
    {
        $fields = $request->getParsedBody() ?? $request->getQueryParams();
        if (!is_array($fields)) {
            $fields = [];
        } else {
            $fields = $this->applyFieldsFilter($fields);
        }

        $files = $request->getUploadedFiles();
        if (!is_array($files)) {
            $files = [];
        }

        return array_merge($fields, $files);
    }

    protected function applyFieldsFilter(array $data): array
    {
        array_walk($data, function (&$value) {
            $value = is_string($value) ? trim($value) : $value;
            $value = is_bool($value) ? (($value) ? 'true' : 'false') : $value;
            if (in_array($value, [null, '', 'null', 'undefined'])) {
                $value = null;
            }
        });

        if (!$this->allowedFields) {
            return $data;
        }

        return array_filter($data, function ($field) {
            return !is_string($field) || in_array($field, $this->allowedFields);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getRenameRelations(): array
    {
        return [];
    }

    protected function getRenameFields(): array
    {
        return [];
    }

    /**
     * For rule "unique"
     * @param array $rules
     * @param int   $id
     * @return bool
     */
    protected function replaceIdInRules(array $rules, int $id): array
    {
        $idReplacer = function ($rule, $id) {
            return str_replace('{id}', $id, $rule);
        };

        array_walk($rules, function (&$rule) use ($idReplacer, $id) {
            if (is_string($rule)) {
                $rule = $idReplacer($rule, $id);
            } elseif (is_array($rule)) {
                array_walk($rule, function (&$singleRule) use ($idReplacer, $id) {
                    $singleRule = $idReplacer($singleRule, $id);
                });
            }
        });

        return $rules;
    }

    protected function validate(array $data, array $rules, int $id = 0, $messages = []): bool
    {
        try {
            $rules = $this->replaceIdInRules($rules, $id);

            $this->validator->validate($data, $rules, $messages);
            return true;
        } catch (ValidationException $e) {
            $this->setError(json_encode($e->errors()));
            return false;
        }
    }
}
