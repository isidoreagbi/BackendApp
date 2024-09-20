<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable {
    use Queueable, SerializesModels;

    public $name;
    public $groupeId;

    public function __construct($name, $groupeId)
    {
        $this->name = $name;
        $this->groupeId = $groupeId;
    }

    public function build()
    {
        $url = route('register'); // URL pour l'inscription de l'utilisateur

        return $this->subject('Invitation à rejoindre un groupe')
                    ->from('no-reply@tonapp.com')
                    ->text('emails.invitation_plain')
                    ->with([
                        'name' => $this->name,
                        'groupeId' => $this->groupeId,
                        'url' => $url,
                    ]);
    }

    public function text($message = null)
    {
        // Contenu du message sous forme de texte brut
        return $this->withSwiftMessage(function ($swiftMessage) use ($message) {
            $swiftMessage->setBody(
                "Bonjour {$this->name},\n\n".
                "Vous avez été invité à rejoindre le groupe avec l'ID : {$this->groupeId}.\n\n".
                "Pour rejoindre le groupe, cliquez sur ce lien et créez un compte si nécessaire :\n{$this->url}\n\n".
                "Merci."
            );
        });
    }
}
