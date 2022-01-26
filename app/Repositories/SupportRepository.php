<?php

namespace App\Repositories;

use App\Models\Support;
use App\Repositories\Traits\RepositoryTrait;

class SupportRepository
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getSupports(array $filters = [])
    {
        return $this->getUserAuth()
            ->supports()
            ->where(function ($query) use ($filters) {
                if (isset($filters['lesson'])) {
                    $query->where('lesson_id', $filters['lesson']);
                }

                if (isset($filters['status'])) {
                    $query->where('status', $filters['status']);
                }

                if (isset($filters['filter'])) {
                    $filter = $filters['filter'];
                    $query->where('description', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('updated_at')
            ->get();
    }

    public function createSupport(array $data): Support
    {
        return $this->getUserAuth()->supports()->create([
            'lesson_id' => $data['lesson'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);
    }

    public function createReplyToSupport($id, $data)
    {
        return $this->getSupport($id)->replies()->create([
            'description' => $data['description'],
            'user_id' => $this->getUserAuth()->id
        ]);
    }

    private function getSupport($id)
    {
        return $this->entity->findOrFail($id);
    }
}