<?php

namespace Database\Seeders;

use App\Models\Advertiser;
use Illuminate\Database\Seeder;

class AdvertiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $advertisers = [

            [
                'id' => 1,
                'name' => 'Advertiser 1',
                'email' => 'advertiser1@ad.com',
            ],
            [
                'id' => 2,
                'name' => 'Advertiser 2',
                'email' => 'advertiser2@ad.com',
            ],

            [
                'id' => 3,
                'name' => 'Advertiser 3',
                'email' => 'advertiser3@ad.com',
            ],
            [
                'id' => 4,
                'name' => 'Advertiser 4',
                'email' => 'advertiser4@ad.com',
            ],
            [
                'id' => 5,
                'name' => 'Advertiser 5',
                'email' => 'advertiser5@ad.com',
            ],
            [
                'id' => 6,
                'name' => 'Advertiser 6',
                'email' => 'advertiser6@ad.com',
            ],
        ];

        Advertiser::insert($advertisers);
    }
}
