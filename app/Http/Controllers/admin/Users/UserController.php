<?php

namespace App\Http\Controllers\admin\Users;

use App\Http\Controllers\Controller;
use App\Services\UserControllerServices;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userControllerServices;

    public function __construct(UserControllerServices $userControllerServices)
    {
        $this->userControllerServices = $userControllerServices;
    }

    public function index(): JsonResponse
    {
        $users = $this->userControllerServices->index();
        return response()->json(UserResource::collection($users));
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userControllerServices->show($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(new UserResource($user));
    }

    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->userControllerServices->destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }
}
