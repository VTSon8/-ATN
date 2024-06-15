<?php

namespace App\Repositories\Account;

use App\Repositories\RepositoryInterface;

interface AccountRepositoryInterface extends RepositoryInterface
{
    public function search($request);
    public function getAllAccount();
    public function createAccount(array $params);
    public function getAccountById($id);
    public function updateAccount($id, array $params);
    public function delete($id);
    public function restoreAccountById($id);
    public function foreverDeleteAccountById($id);
    public function totalTrash();
    public function getOnlyTrashed();
}
