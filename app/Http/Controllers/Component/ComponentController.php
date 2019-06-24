<?php

namespace App\Http\Controllers\Component;

use App\Component;
use App\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class ComponentController extends ApiController
{
    // Show all components
    public function index()
    {
        if ($this->isLoggedIn()) {
            $cached = IlluminateCache::remember('components', 10, function () {
                $components = Component::all();
                $synthKey = $this->getSynthComponents();
                return [
                    'data' => $components,
                    'synthKey' => $synthKey
                ];
            });
            $data = $cached['data'];
            $synthKey = $cached['synthKey'];
            return $this->showMany($data, "All the components", $synthKey);
        }
    }

    // Store a new component
    public function store(Request $request)
    {
        if ($this->isAdminAndLoggedIn()) {
            $rules = [
                'brand' => 'required|min:2|max:150',
                'model' => 'required|min:2|max:150',
                'description' => 'required|min:2|max:150',
                'machine_id' => 'required|integer|min:1'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $machine = Machine::findorFail($fields['machine_id']);
            $fields['isRoot'] = 0; // Prevent creating root components from outside
            $component = new Component($fields);
            $component->machine()->associate($machine);
            $component->save();
            $this->synthComponents();
            return $this->showOne($component, "Component created");
        }
    }

    // Update a component
    public function update(Request $request, $id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $component = Component::findorFail($id);
            if ($component->isRoot) {
                return $this->errorResponse("No puedes actualizar el componente raíz", 401); // Prevent root edition
            }
            $rules = [
                'brand' => 'min:2|max:150',
                'model' => 'min:2|max:150',
                'description' => 'min:2|max:150',
                'machine_id' => 'integer|min:1'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $fields['isRoot'] = 0; // Prevent making root components from outside
            if ($request->has('machine_id')) {
                $machine = Machine::findorFail($fields['machine_id']);
                $component->machine()->associate($machine);
            }
            $component->update($fields);
            $this->synthComponents();
            return $this->showOne($component, "Component updated");
        }
    }

    // Delete a component
    public function destroy($id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $component = Component::findorFail($id);
            if ($component->isRoot) {
                return $this->errorResponse("No puedes eliminar el componente raíz", 401); // Prevent root edition
            }
            $component->delete();
            $this->synthComponents();
            return $this->showOne($component, "Component deleted");
        }
    }
}
