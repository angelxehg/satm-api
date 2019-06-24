<?php

namespace App\Http\Controllers\Material;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class MaterialController extends ApiController
{
    // Show all materials
    public function index()
    {
        if ($this->isLoggedIn()) {
            $cached = IlluminateCache::remember('materials', 10, function () {
                $materials = Material::all();
                $synthKey = $this->getSynthMaterials();
                return [
                    'data' => $materials,
                    'synthKey' => $synthKey
                ];
            });
            $data = $cached['data'];
            $synthKey = $cached['synthKey'];
            return $this->showMany($data, "All the materials", $synthKey);
        }
    }

    // Store a new material
    public function store(Request $request)
    {
        if ($this->isAdminAndLoggedIn()) {
            $rules = [
                'brand' => 'required|min:2|max:150',
                'model' => 'required|min:2|max:150',
                'description' => 'required|min:2|max:150',
                'quantity' => 'required|integer|min:1|max:1000'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $material = new Material($fields);
            $material->save();
            $this->synthMaterials();
            return $this->showOne($material, "Material created");
        }
    }

    // Update a material
    public function update(Request $request, $id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $material = Material::findorFail($id);
            $rules = [
                'brand' => 'min:2|max:150',
                'model' => 'min:2|max:150',
                'description' => 'min:2|max:150',
                'quantity' => 'integer|min:1|max:1000'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $material->update($fields);
            $this->synthMaterials();
            return $this->showOne($material, "Material updated");
        }
    }

    // Delete a material
    public function destroy($id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $material = Material::findorFail($id);
            $material->delete();
            $this->synthMaterials();
            return $this->showOne($material, "Material deleted");
        }
    }
}
