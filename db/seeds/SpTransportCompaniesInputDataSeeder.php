<?php

use Phinx\Seed\AbstractSeed;

class SpTransportCompaniesInputDataSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'SpTransportCompaniesSeeder'
        ];
    }

    public function run()
    {
        $data = [
            [
                'transport_companies_id' => 1,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 1,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 1,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 2,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 2,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 2,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 3,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 3,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 3,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 4,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 4,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 4,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 5,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 5,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 5,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 6,
                'title' => 'кладр от куда везем',
                'type' => 'string',
                'code' => 'sourceKladr',
            ],
            [
                'transport_companies_id' => 6,
                'title' => 'кладр куда везем',
                'type' => 'string',
                'code' => 'targetKladr',
            ],
            [
                'transport_companies_id' => 6,
                'title' => 'вес отправления в кг',
                'type' => 'float',
                'code' => 'weight',
            ],
            [
                'transport_companies_id' => 6,
                'title' => 'Коэффициент расчета',
                'type' => 'float',
                'code' => 'coefficient',
                'default_value' => '1.2'
            ],
        ];

        $sp_tc = $this->table('sp_transport_companies_input_data');
        $sp_tc->insert($data)->save();
    }
}
