<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as IlluminateCache;
use App\Synth;

class SynthController extends ApiController
{
    public function index()
    {
        if ($user = auth()->user()) {
            $isAdmin = false;
            if ($user->isAdmin) {
                $isAdmin = true;
            }
            $synthKeys = IlluminateCache::remember('probeKeys', 10, function () {
                $synths = Synth::all();
                $fiveKeys = [
                    'machines' => $synths[0]->synthKey,
                    'components' => $synths[1]->synthKey,
                    'users' => $synths[2]->synthKey,
                    'tasks' => $synths[3]->synthKey,
                    'materials' => $synths[4]->synthKey,
                ];
                return $fiveKeys;
            });
            return $this->synthResponse(false, true, $isAdmin, $synthKeys, 200, $user);
        } else {
            return $this->synthResponse(true, false, false, false, 401, false);
        }
    }
}
