<?php

namespace App\Http\Controllers;

use App\Interfaces\MembreInterface;
use App\Http\Requests\AddMembreRequest;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MembreController extends Controller
{
    protected $membreRepo;

    public function __construct(MembreInterface $membreRepo) {
        $this->membreRepo = $membreRepo;
    }

    public function addMembre(AddMembreRequest $request, $groupeId)
    {
        $groupe = Groupe::find($groupeId);
        if (!$groupe) {
            return response()->json(['message' => 'Groupe introuvable.'], 404);
        }

        $membre = $this->membreRepo->addMembre($groupeId, $request->only('email', 'name'));

        return response()->json(['message' => 'Membre ajouté avec succès.', 'membre' => $membre], 201);
    }
    
    
    // private function sendInvitationEmail($email, $name, $groupeId) {
    //     $invitationLink = route('register', ['groupe_id' => $groupeId, 'email' => $email]);
    
    //     $message = "Bonjour $name,\n\n";
    //     $message .= "Vous avez été invité à rejoindre un groupe. Cliquez sur le lien ci-dessous pour créer votre compte :\n";
    //     $message .= $invitationLink;
    
    //     // Envoi de l'email avec le texte d'invitation
    //     Mail::raw($message, function($msg) use ($email) {
    //         $msg->to($email)
    //             ->subject('Invitation à rejoindre le groupe');
    //     });
    // }
    
    

    public function removeMembre($groupeId, $membreId) {
        $this->membreRepo->removeMembre($groupeId, $membreId);
        return response()->json(['message' => 'Membre supprimé avec succès.'], 204);
    }

    public function listMembres($groupeId) {
        $membres = $this->membreRepo->listMembres($groupeId);
        return response()->json($membres, 200);
    }
}
