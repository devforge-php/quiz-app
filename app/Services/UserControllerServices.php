<?php 

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserControllerServices
{
    public function index(): Collection
    {
        return User::all();
    }

    public function show(string $id): ?User
    {
        return User::find($id);
    }

    public function destroy(string $id): bool
    {
        $user = User::find($id);
        
        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}
