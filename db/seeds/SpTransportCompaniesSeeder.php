<?php
use Phinx\Seed\AbstractSeed;

class SpTransportCompaniesSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'SpServicesSeeder'
        ];
    }

    public function run()
    {
        $data = [
            [
                'services_id' => 1,
                'title' => 'delivery company Ovechcin IP',
                'short_title' => 'OvechcinDelivery',
                'base_url' => 'http://ovechcin.ru',
            ],
            [
                'services_id' => 1,
                'title' => 'delivery company OOO SpeedDeliv',
                'short_title' => 'SpeedDeliv',
                'base_url' => 'http://speed-deliv.ru',
            ],
            [
                'services_id' => 2,
                'title' => 'delivery company Kolin',
                'short_title' => 'KolinDelivery',
                'base_url' => 'http://KolinDelivery.ru',
            ],
            [
                'services_id' => 2,
                'title' => 'delivery company Serov',
                'short_title' => 'SerovDeliv',
                'base_url' => 'http://SerovDeliv.ru',
            ],
            [
                'services_id' => 2,
                'title' => 'delivery company Petrov',
                'short_title' => 'PetrovDelivery',
                'base_url' => 'http://PetrovDelivery.ru',
            ],
            [
                'services_id' => 2,
                'title' => 'delivery company Suslov',
                'short_title' => 'SuslovDeliv',
                'base_url' => 'http://Suslov-deliv.ru',
            ],
        ];

        $sp_tc = $this->table('sp_transport_companies');
        $sp_tc->insert($data)->save();
    }
}
