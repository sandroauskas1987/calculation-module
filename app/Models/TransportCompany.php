<?php

namespace App\Models;

use App\Migration\Migration;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportCompanyInputData;

/**
 * @OA\Schema(schema="Line",
 *   title="Модель транспортной компании",
 *   required={"title","short_title","base_url"},
 *   @OA\Property(
 *     property="title",
 *     type="string",
 *     description="Наименование компании",
 *     example="ООО Быстрая доставка",
 *   ),
 *   @OA\Property(
 *     property="short_title",
 *     type="string",
 *     description="Сокращенное наименование компании",
 *     example="Быстрая доставка",
 *   ),
 *   @OA\Property(
 *     property="base_url",
 *     type="string",
 *     description="базовый URL-адрес",
 *     example="https://sped-delivery",
 *   ),
 * )
 */

class TransportCompany extends Model
{
    public const TABLE = 'sp_transport_companies';

    public    $table   = self::TABLE;
    protected $hidden  = [Migration::FIELD_CREATED_AT, Migration::FIELD_UPDATED_AT];
    protected $guarded = [self::PRIMARY_KEY];
    protected $fillable = [self::FIELD_TITLE];

    public const PRIMARY_KEY = 'id';
    public const FIELD_TITLE = 'title';

    /**
     * Параметры компаний участвующие в запросах к сервисам и расчетам доставок
     */
    public function params()
    {
        return $this->hasMany(TransportCompanyInputData::class, 'transport_companies_id', 'id');
    }

    /** 
     * Получить параметры всех компаний по id службы доставки
     * @param int $services_id 
     * @return array[]
     */
    public static function getParams(int $services_id):array
    {
        return self::query()
            ->with('params')
            ->where(['services_id' => $services_id])
            ->get()
            ->map(function ($company) {
                $par = [];
                if (isset($company->params)) {
                    foreach ($company->params as $value) {
                        $par[$value['code']] = $value['default_value'];
                    }
                }
                return [
                    "Company_name" => $company->title,
                    "base_url" => $company->base_url,
                    "params" => $par
                ];
            })->toArray();

    }

}
