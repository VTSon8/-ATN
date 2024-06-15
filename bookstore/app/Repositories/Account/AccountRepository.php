<?php

namespace App\Repositories\Account;

use App\Models\Account;
use App\Repositories\BaseRepository;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{

    public function getModel()
    {
        return Account::class;
    }

    public function search($request)
    {
        $query = $this->model->query()->when($request->get('search'), function ($query, $search) {
            $search = strtolower(trim($search));
            return $query->whereRaw('LOWER(username) LIKE ?', ["%$search%"]);
        })->when($request->get('sort'), function ($query, $sortBy) {
            if (is_array($sortBy) && isset($sortBy['key']) && isset($sortBy['order'])) {
                return $query->orderBy($sortBy['key'], $sortBy['order']);
            }
            return $query;
        });

        $data = $query->paginate($request->get('limit', 10));

        return $data;
    }

    public function getAllAccount()
    {
        return $this->model->with('child', 'role')->where('role_id', '<>', 120)->paginate(config('constants.pagination'));
    }

    public function createAccount(array $params)
    {
        return $this->model->create($params);
    }

    public function getAccountById($id)
    {
        return $this->model->whereId($id)->first();
    }

    public function updateAccount($id, array $params)
    {
        return $this->model->whereId($id)->update($params);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function restoreAccountById($id)
    {
        return $this->model->withTrashed()->whereId($id)->restore();
    }

    public function foreverDeleteAccountById($id)
    {
        return $this->model->withTrashed()->whereId($id)->forceDelete();
    }

    public function totalTrash()
    {
        return $this->model->onlyTrashed()->count();
    }

    public function getOnlyTrashed()
    {
        return $this->model->onlyTrashed()->with('account')->paginate(config('constants.pagination'));
    }
}
