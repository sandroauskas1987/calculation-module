<?php
use Phinx\Seed\AbstractSeed;

class SpServicesSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'title' => 'Быстрая доставка',
                'code' => 'FastDelivery',
            ],
            [
                'title' => 'Медленная доставка',
                'code' => 'SlowDelivery',
            ]
        ];

        $sp_tc = $this->table('sp_services');
        $sp_tc->insert($data)->save();
    }
}
