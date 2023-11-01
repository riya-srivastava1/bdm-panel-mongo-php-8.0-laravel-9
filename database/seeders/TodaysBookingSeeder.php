<?php

namespace Database\Seeders;

use App\Models\TodaysBooking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodaysBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TodaysBooking::factory(50)->create();
        TodaysBooking::factory()->create([
            'user_name' => '23',
            'gender' => 'Female',
            'artist' => 'fmfmfkmmfvk',
            'location' => 'LKO',
            'services' => 'jhfjhfvjjvhjfh'
        ]);
    }
}
