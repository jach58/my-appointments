<?php

use App\User;
use App\Specialty;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Oftalmología',
            'Pediatría',
            'Neurología'
        ];

        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);

            $specialty->users()->saveMany(
                factory(App\User::class, 3)->states('doctor')->make()
            );
        }

        User::find(3)->specialties()->save($specialty);
    }
}
