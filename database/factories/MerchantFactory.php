<?php

namespace Database\Factories;

use App\Models\Lapangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'nomor' => $this->faker->phoneNumber(),
            'status_merchant' => "active",
            'bank' => "bank bank an",
            'norek' => "10129388712",
            'buka' => '09:00:00',
            'tutup' => '21:00:00',
            'pembayaran' => 'both',
            'dp' => 1,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function ($merch) {
            $laps = Lapangan::factory()->count(3)
                ->for($merch)
                ->create();
        });
    }
}
