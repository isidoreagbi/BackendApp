<?php

// app/Http/Controllers/GroupeController.php
namespace App\Http\Controllers;

use App\Interfaces\GroupeInterface;
use App\Http\Requests\CreateGroupeRequest;
use App\Http\Requests\UpdateGroupeRequest;

class GroupeController extends Controller {
    protected $groupeRepo;

    public function __construct(GroupeInterface $groupeRepo) {
        $this->groupeRepo = $groupeRepo;
    }

    public function store(CreateGroupeRequest $request) {
        $groupe = $this->groupeRepo->createGroupe($request->validated());
        return response()->json($groupe, 201);
    }

    public function index() {
        $groupes = $this->groupeRepo->getAllGroupes();
        return response()->json($groupes, 200);
    }

    public function show($id) {
        $groupe = $this->groupeRepo->getGroupeById($id);
        return response()->json($groupe, 200);
    }

    public function update($id, UpdateGroupeRequest $request) {
        $groupe = $this->groupeRepo->updateGroupe($id, $request->validated());
        return $groupe ? response()->json($groupe, 200) : response()->json(['message' => 'Groupe non trouvé.'], 404);
    }

    public function destroy($id) {
        $deleted = $this->groupeRepo->deleteGroupe($id);
        return $deleted ? response()->json(['message' => 'Groupe supprimé.'], 204) : response()->json(['message' => 'Groupe non trouvé.'], 404);
    }
}
