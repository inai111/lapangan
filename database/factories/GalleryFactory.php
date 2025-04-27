<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    protected $model = Gallery::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'photo' => str()->random(10).'.jpg'
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($gal) {
            $lapangan = $gal->lapangan;
            $nama_dir = str_replace(' ', '_', $lapangan->nama);
            $int = rand(1,14);
            Storage::disk('public')->copy("img/default/lapangan$int.jpg","img/$nama_dir/{$gal->photo}");
        });
    }
}
