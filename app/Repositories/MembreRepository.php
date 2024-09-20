<?php

namespace App\Repositories;

use App\Interfaces\MembreInterface;
use App\Mail\InvitationMail;
use App\Models\Groupe;
use App\Models\Membre;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MembreRepository implements MembreInterface
{
    public function addMembre($groupeId, array $membreData)
    {
        
        $groupe = Groupe::find($groupeId);
        if (!$groupe) {

            return response()->json(['message' => 'Groupe introuvable.'], 404);
        }

        $user = $this->getUserByEmail($membreData['email']);

        if ($user) {
            $membreData['user_id'] = $user->id;
        } else {
            $membreData['user_id'] = null;
            $this->sendInvitationEmail($membreData['email'], $membreData['name'], $groupeId);
        }

        $membre = Membre::create(array_merge($membreData, ['groupe_id' => $groupeId]));

        return $membre;
    }


    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function sendInvitationEmail($email, $name, $groupeId)
    {
        Mail::to($email)->send(new InvitationMail($name, $groupeId));
    }

    public function removeMembre($groupeId, $membreId)
    {
        $membre = Membre::where('groupe_id', $groupeId)->findOrFail($membreId);
        $membre->delete();
    }

    public function listMembres($groupeId)
    {
        return Membre::where('groupe_id', $groupeId)->get();
    }

    public function getGroupeById($groupeId)
    {
        return Groupe::find($groupeId);
    }
}
