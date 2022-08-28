<?php

use App\Migration\Migration;
use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Table;

final class SpTransportCompaniesInputData extends Migration
{
    protected $tableName        = 'sp_transport_companies_input_data';
    protected $tableComment     = 'Справочник транспортных компаний';

    protected function buildTable(): Table
    {
        $table = $this->table($this->tableName)
            ->addColumn('transport_companies_id', AdapterInterface::PHINX_TYPE_INTEGER, ['null' => false, 'comment' => 'Идентификатор транспортной компании'])
            ->addColumn('title', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255, 'null' => false, 'comment' => 'Название параметра'])
            ->addColumn('type', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100, 'null' => false, 'comment' => 'Тип параметра'])
            ->addColumn('code', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100, 'null' => false, 'comment' => 'Код параметра'])
            ->addColumn('default_value', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 100,'null' => true, 'comment' => 'Значение по умолчанию'])
            ->addTimestamps()
            ->addForeignKey(
                'transport_companies_id',
                'sp_transport_companies',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_transport_companies_input_data']
            );
        return $table;
    }

}
