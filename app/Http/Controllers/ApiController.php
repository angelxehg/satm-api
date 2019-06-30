<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class ApiController extends Controller {
    
    use ApiResponser;

    protected function isLogged() {
        if ($user = auth()->user()) {
            return $user;
        } else {
            throw new AuthenticationException();
        }
    }

    protected function waterfallValidation($affectedUser) {
        $currentUser = $this->isLoggedIn();
        if ($currentUser->isAdmin) {
            // Is admin or himself
            if (!$affectedUser->isAdmin || $affectedUser->id == $currentUser->id) {
                // Permision to change a non-admin
                return ['current' => $currentUser, 'permited' => true, 'message' => 'OK'];
            } else {
                // affectedUser is an admin, so...
                if ($currentUser->id == 1) {
                    // Permision to do everything
                    return ['current' => $currentUser, 'permited' => true, 'message' => 'OK'];
                } else {
                    // No permision
                    return ['permited' => false, 'message' => 'No tienes permiso para modificar otros administradores' ];
                }
            }
        } else {
            // Is not admin
            if ($currentUser->id = $affectedUser->id) {
                // Permision to change own info
                return ['current' => $currentUser, 'permited' => true, 'message' => 'OK'];
            } else {
                // No permision
                return ['permited' => false, 'message' => 'No tienes permiso para modificar otros usuarios' ];
            }
        }
    }

    protected function isAdminAndLoggedIn() {
        $user = $this->isLoggedIn();
        if ($user->isAdmin) {
            return $user;
        } else {
            throw new NotAdminException();
        }
    }

    protected function getSynthMachines() {
        return $this->getSynth(1);
    }

    protected function getSynthComponents() {
        return $this->getSynth(2);
    }

    protected function getSynthUsers() {
        return $this->getSynth(3);
    }

    protected function getSynthTasks() {
        return $this->getSynth(4);
    }

    protected function getSynthMaterials() {
        return $this->getSynth(5);
    }

    protected function getSynth($id) {
        return Synth::find($id)->synthKey;
    }

    protected function synthMachines() {
        $this->synthChanges(1);
    }

    protected function synthComponents() {
        $this->synthChanges(2);
    }

    protected function synthUsers() {
        $this->synthChanges(3);
    }

    protected function synthTasks() {
        $this->synthChanges(4);
    }

    protected function synthMaterials() {
        $this->synthChanges(5);
    }

    private function synthChanges($id) {
        $synth = Synth::find($id);
        $synth->synthKey = Hash::make(now());
        $synth->save();
    }

    protected function reHashIt($object) {
        $object->hashKey = Hash::make(now());
    }
    
    protected function reHashItSave($object) {
        $object->hashKey = Hash::make(now());
        $object->save();
    }
}
