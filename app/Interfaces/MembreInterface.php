<?php

namespace App\Interfaces;

interface MembreInterface
{
    public function addMembre($groupeId, array $membreData);
    public function getUserByEmail(string $email);
    // public function sendInvitationEmail(string $email, string $invitationUrl);
    public function removeMembre($groupeId, $membreId);
    public function listMembres($groupeId);
}
