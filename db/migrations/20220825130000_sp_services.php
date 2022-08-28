<?php

use App\Migration\Migration;
use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Table;

final class SpServices extends Migration
{
    protected $tableName        = 'sp_services';
    protected $tableComment     = 'Справочник служб';

    protected function buildTable(): Table
    {
        $table = $this->table($this->tableName)
            ->addColumn('title', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255, 'null' => false, 'comment' => 'Наименование службы'])
            ->addColumn('code', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100, 'null' => false, 'comment' => 'Код службы'])
            ->addTimestamps()
            ->addIndex('code', [
                'unique' => true,
                'name'   => 'idx_sp_services',
            ]);
        return $table;
    }
}
