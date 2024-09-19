<?php

namespace App\Repositories;

use App\Interfaces\GroupeInterface;
use App\Models\Groupe;

class GroupeRepository implements GroupeInterface {
    public function getAllGroupes() {
        return Groupe::all();
    }

    public function getGroupeById($id) {
        return Groupe::find($id);
    }

    public function createGroupe(array $data) {
        return Groupe::create($data);
    }

    public function updateGroupe($id, array $data) {
        $groupe = Groupe::find($id);
        $groupe->update($data);
        return $groupe;
    }

    public function deleteGroupe($id) {
        return Groupe::destroy($id);
    }
}
