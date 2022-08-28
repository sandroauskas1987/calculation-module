<?php

namespace App\Models;

use App\Migration\Migration;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportCompany;

/**
 * @OA\Schema(schema="service",
 *   title="Модель служб",
 *   required={"title","code"},
 *   @OA\Property(
 *     property="title",
 *     type="string",
 *     description="Наименование службы",
 *     example="ООО Быстрая доставка"
 *   ),
 *   @OA\Property(
 *     property="code",
 *     type="string",
 *     description="Код службы",
 *     example="Быстрая доставка"
 *   )
 * )
 */
class Service extends Model
{
    public const TABLE = 'sp_services';

    public    $table   = self::TABLE;
    protected $hidden  = [Migration::FIELD_CREATED_AT, Migration::FIELD_UPDATED_AT];
    protected $guarded = [self::PRIMARY_KEY];
    protected $fillable = [self::FIELD_TITLE];

    public const PRIMARY_KEY = 'id';
    public const FIELD_TITLE = 'title';

    /**
     * Компании принадлежащие службе
     */
    public function companies()
    {
        return $this->hasMany(TransportCompany::class, 'services_id','id');
    }
}
