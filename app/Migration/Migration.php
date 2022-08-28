<?php

namespace App\Migration;

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Table;
use Phinx\Migration\AbstractMigration;

/**
 * @OA\Schema(schema="PrimaryKey",
 *   type="integer",
 *   title="ID",
 *   readOnly=true,
 *   example=1,
 * )
 * @OA\Schema(schema="createdAt",
 *   type="string",
 *   format="date-time",
 *   description="Дата создания",
 *   readOnly=true,
 *   example="2022-03-14T09:48:01.863856Z",
 * )
 * @OA\Schema(schema="updatedAt",
 *   type="string",
 *   format="date-time",
 *   description="Дата изменения",
 *   example="2022-03-14T09:52:14.735294Z",
 * )
 */
class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $schema */
    public $schema;
    /** @var string $tableName */
    protected $tableName = '';
    protected $tableComment = '';

    public const FIELD_CREATED_AT = 'created_at';
    public const FIELD_UPDATED_AT = 'updated_at';

    protected function buildTable(): Table
    {
        return $this->table($this->tableName);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function addTimestamp(Table $table): Table
    {
        return $table
            ->addColumn(self::FIELD_CREATED_AT, AdapterInterface::PHINX_TYPE_DATETIME, [
                'default' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn(self::FIELD_UPDATED_AT, AdapterInterface::PHINX_TYPE_DATETIME, [
                'default' => 'CURRENT_TIMESTAMP',
            ]);
    }

    public function up()
    {
        $table = $this->buildTable();

        //Save
        $table->create();
        if ($this->tableComment) {
            $table
                ->changeComment($this->tableComment)
                ->update();
        }
    }

    public function down()
    {
        $this->table($this->tableName)->drop()->save();
    }

}
