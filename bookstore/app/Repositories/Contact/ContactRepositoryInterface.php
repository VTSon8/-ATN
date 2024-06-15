<?php

namespace App\Repositories\Contact;

interface ContactRepositoryInterface
{
    public function getAllContact();

    public function createContact(array $params);

    public function getContactById($id);

    public function updateContact($id, array $params);

}
