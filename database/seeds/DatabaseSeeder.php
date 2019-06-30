<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Synth;
use App\Machine;
use App\Component;
use App\Material;
use App\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create default admin
        $adminData = [
            'first_name' => "Root",
            'last_name' => "User",
            'email' => "admin@utzac.edu.mx",
            'password' => Hash::make('admin1234'),
            'hability' => 'Administración',
            'isAdmin' => true
        ];
        $admin = new User($adminData);
        $admin->save();
        // Generate 5 keys
        for ($i = 0; $i < 5; $i++) {
            $synths = [
                'synthKey' => Hash::make(now())
            ];
            $synth = new Synth($synths);
            $synth->save();
        }
        // 
        $makeFake = false;
        if ($makeFake) {
            // Machines
            Machine::flushEventListeners();
            $machines = 100;
            factory(Machine::class, $machines)->create()->each(function ($machine) {
                $rootComponentData = ['brand' => 'raíz', 'model' => '', 'description' => 'Componente raíz del equipo. Crear una tarea aquí se considerará una tarea del equipo y no de componente', 'isRoot' => true];
                $rootComponent = new Component($rootComponentData);
                $rootComponent->machine()->associate($machine);
                $rootComponent->save();
            });
            // Components
            Component::flushEventListeners();
            $components = 1000;
            factory(Component::class, $components)->create()->each(function ($component) {
                $faker = Faker\Factory::create();
                $machine_id = $faker->numberBetween($min = 1, $max = 100);
                $machine = Machine::find($machine_id);
                $component->machine()->associate($machine);
                $component->save();
            });
            // Users
            User::flushEventListeners();
            $users = 50;
            factory(User::class, $users)->create();
            // Materials
            Material::flushEventListeners();
            $materials = 75;
            factory(Material::class, $materials)->create();
            // Tasks
            Task::flushEventListeners();
            $tasks = 100;
            factory(Task::class, $tasks)->create()->each(function ($task) {
                $faker = Faker\Factory::create();
                $component_id = $faker->numberBetween($min = 1, $max = 1000);
                $user_id = $faker->numberBetween($min = 1, $max = 50);
                $component = Component::find($component_id);
                $user = User::find($user_id);
                $task->component()->associate($component);
                $task->user()->associate($user);
                $task->save();
            });
        }
    }
}
