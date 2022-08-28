<?php

use App\Migration\Migration;
use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Table;

final class SpTransportCompanies extends Migration
{
    protected $tableName        = 'sp_transport_companies';
    protected $tableComment     = 'Справочник транспортных компаний';

    protected function buildTable(): Table
    {
        $table = $this->table($this->tableName)
            ->addColumn('services_id', AdapterInterface::PHINX_TYPE_INTEGER, ['null' => false, 'comment' => 'Идентификатор сервиса'])
            ->addColumn('title', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255, 'null' => false, 'comment' => 'Наименование компании'])
            ->addColumn('short_title', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100, 'null' => false, 'comment' => 'Сокращенное наименование компании'])
            ->addColumn('base_url', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100, 'null' => false, 'comment' => 'базовый URL-адрес'])
            ->addTimestamps()
            ->addIndex('title', [
                'unique' => true,
                'name'   => 'idx_sp_transport_companies',
            ])->addForeignKey(
                'services_id',
                'sp_services',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_transport_companies_services']
            );
        return $table;
    }

}
