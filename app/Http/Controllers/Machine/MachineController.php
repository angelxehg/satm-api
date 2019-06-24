<?php

namespace App\Http\Controllers\Machine;

use App\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache as IlluminateCache;
use App\Component;

class MachineController extends ApiController
{
    // Show all machines
    public function index()
    {
        if ($this->isLoggedIn()) {
            $cached = IlluminateCache::remember('machines', 10, function () {
                $machines = Machine::all();
                $synthKey = $this->getSynthMachines();
                return [
                    'data' => $machines,
                    'synthKey' => $synthKey
                ];
            });
            $data = $cached['data'];
            $synthKey = $cached['synthKey'];
            return $this->showMany($data, "All the machines", $synthKey);
        }
    }

    // Store a new machine
    public function store(Request $request)
    {
        if ($this->isAdminAndLoggedIn()) {
            $rules = [
                'brand' => 'required|min:2|max:150',
                'model' => 'required|min:2|max:150',
                'description' => 'required|min:2|max:150',
                'ubication' => 'required|min:2|max:150'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $machine = new Machine($fields);
            $machine->save();
            $rootComponentData = ['brand' => 'raíz', 'model' => '', 'description' => 'Componente raíz del equipo. Crear una tarea aquí se considerará una tarea del equipo y no de componente', 'isRoot' => true];
            $rootComponent = new Component($rootComponentData);
            $rootComponent->machine()->associate($machine);
            $rootComponent->save();
            $this->synthMachines();
            $this->synthComponents();
            return $this->showOne($machine, "Machine created");
        }
    }
    
    // Update a machine
    public function update(Request $request, $id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $machine = Machine::findorFail($id);
            $rules = [
                'brand' => 'min:2|max:150',
                'model' => 'min:2|max:150',
                'description' => 'min:2|max:150',
                'ubication' => 'min:2|max:150'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $machine->update($fields);
            $this->synthMachines();
            return $this->showOne($machine, "Machine updated");
        }
    }

    // Delete a machine
    public function destroy($id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $machine = Machine::findorFail($id);
            $machine->delete();
            $this->synthMachines();
            return $this->showOne($machine, "Machine deleted");
        }
    }
}
