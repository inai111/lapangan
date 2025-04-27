<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\Lapangan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lapangan>
 */
class LapanganFactory extends Factory
{
    protected $model = Lapangan::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->unique()->colorName(),
            'harga' => rand(10000, 100000),
            'jenis_olahraga_id' => rand(1, 6),
            'status' => 'ada',
            'cover' => "default.png",
            'deskripsi' => $this->faker->paragraph()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($lapangan) {
            $nama_dir = str_replace(' ', '_', $lapangan->nama);

            Storage::disk('public')->copy('img/lapangan/cover/default.png',"img/$nama_dir/cover/default.png");
            Gallery::factory()->count(2)->for($lapangan)->create();
        });
    }
}
