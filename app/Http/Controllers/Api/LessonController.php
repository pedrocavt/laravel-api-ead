<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Repositories\LessonRepository;

class LessonController extends Controller
{
    protected $repository;

    public function __construct(LessonRepository $courseRepository) {
        $this->repository = $courseRepository;
    }

    public function index($moduleId) {
        $lessons = $this->repository->getLessonsByModuleId($moduleId);
        return LessonResource::collection($lessons);
    }

    public function show($id) {
        $lesson = $this->repository->getLesson($id);

        return new LessonResource($lesson);
    }
}
