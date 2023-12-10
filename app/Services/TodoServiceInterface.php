<?php

namespace App\Services;

use App\Models\User;

interface TodoServiceInterface
{
    public function getId(int $id);
    public function getByUser(User $user);
    public function getByStatus(string $status);

    public function add($todo);
}