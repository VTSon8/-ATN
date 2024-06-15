<?php

namespace App\Repositories\Contact;


use App\Models\Contact;
use App\Repositories\BaseRepository;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function getAllContact()
    {
        return Contact::query()->paginate(config('constants.pagination'));
    }

    public function createContact(array $params)
    {
        return Contact::create($params);
    }

    public function getContactById($id)
    {
        return Contact::whereId($id)->first();
    }

    public function updateContact($id, array $params)
    {
        return Contact::whereId($id)->update($params);
    }

    public function getModel()
    {
        return Contact::class;
    }
}
