<?php

namespace App\Services;

use App\Http\Resources\ProfileReosurce;
use App\Models\Notifaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserNotifactionResource;


class LogikServices
{
    public function search(Request $request)
    {
      // Qidiruv so'rovini olish
      $query = $request->input('user_name');
  
      // Userlar jadvalidan qidiruvni amalga oshirish
      $users = User::where('user_name', 'LIKE', '%' . $query . '%')
                   ->with('profile') // Profile bilan bog'langan ma'lumotlarni yuklash
                   ->get();
  
      // Natijani qaytarish
      return response()->json(ProfileReosurce::collection($users));    
    }

    public function levels()
    {
   
        $topUsers = User::orderBy('score', 'desc') // 'desc' yoki 'asc'
        ->take(10)
        ->get();

return response()->json(ProfileReosurce::collection($topUsers));
    }

    public function getAllNotifactions()
    {
        return UserNotifactionResource::collection(Notifaction::paginate(10));
    }

    public function getNotifactionById(string $id)
    {
        $notifaction = Notifaction::find($id);
        return $notifaction ? new UserNotifactionResource($notifaction) : null;
    }

    public function deleteNotifaction(string $id): array
    {
        $notifaction = Notifaction::find($id);

        if ($notifaction) {
            $notifaction->delete();
            return ['message' => 'Deleted successfully'];
        }

        return ['message' => 'Notification not found'];
    }
}


?>