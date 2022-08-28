<?php

namespace App\Models;

use App\Migration\Migration;
use Illuminate\Database\Eloquent\Model;

/**
 * -@OA\Schema(schema="Line2",
 *   title="Модель параметров транспортной компании",
 *   required={"title","short_title","base_url"},
 *   -@OA\Property(
 *     property="title",
 *     type="string",
 *     description="Название параметра",
 *     example="кладр куда везем",
 *   ),
 *   -@OA\Property(
 *     property="type",
 *     type="string",
 *     description="Тип параметра",
 *     example="string",
 *   ),
 *   -@OA\Property(
 *     property="code",
 *     type="string",
 *     description="Код параметра",
 *     example="targetKladr ",
 *   ),
 *   -@OA\Property(
 *     property="default_value",
 *     type="string",
 *     description="Значение по умолчанию",
 *     example="Москва ",
 *   )
 * )
 */
class TransportCompanyInputData extends Model
{
    public const TABLE = 'sp_transport_companies_input_data';

    public    $table   = self::TABLE;
    protected $hidden  = [Migration::FIELD_CREATED_AT, Migration::FIELD_UPDATED_AT];
    protected $guarded = [self::PRIMARY_KEY];
    protected $fillable = [self::FIELD_TITLE];

    public const PRIMARY_KEY = 'id';
    public const FIELD_TITLE = 'title';

}
