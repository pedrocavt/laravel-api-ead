<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\ReplySupportResource;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $repository;

    public function __construct(SupportRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function index(Request $request)
    {
        $supports = $this->repository->getSupports($request->all());

        return SupportResource::collection($supports);
    }

    public function store(StoreSupport $request)
    {
        $supports = $this->repository->createSupport($request->validated());

        return new SupportResource($supports);
    }

    public function createReply(StoreReplySupport $request, $id)
    {
        $reply = $this->repository->createReplyToSupport($id, $request->validated());

        return new ReplySupportResource($reply);
    }
}
