<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Models\User;
use App\Repositories\Traits\RepositoryTrait;

class ReplySupportRepository
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(ReplySupport $model)
    {
        $this->entity = $model;
    }

    public function createReplyToSupport($data)
    {
        return $this->entity->create([
            'support_id' => $data['support'],
            'description' => $data['description'],
            'user_id' => $this->getUserAuth()->id
        ]);
    }
}