<?php

namespace App\Http\Controllers\admin\Notifactions;

use App\Http\Controllers\Controller;
use App\Services\LogikServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserNotifactionController extends Controller
{
    protected $logikService;

    public function __construct(LogikServices $logikService)
    {
        $this->logikService = $logikService;
    }

    public function index(Request $request): JsonResponse
    {
        $notifactions = $this->logikService->getAllNotifactions();
        return response()->json($notifactions);
    }

    public function show(string $id): JsonResponse
    {
        $notifaction = $this->logikService->getNotifactionById($id);
        return response()->json($notifaction);
    }

    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->logikService->deleteNotifaction($id);
        return response()->json($deleted);
    }
}
