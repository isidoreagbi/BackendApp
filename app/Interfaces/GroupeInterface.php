<?php

namespace App\Interfaces;

interface GroupeInterface {
    public function getAllGroupes();
    public function getGroupeById($id);
    public function createGroupe(array $data);
    public function updateGroupe($id, array $data);
    public function deleteGroupe($id);
}