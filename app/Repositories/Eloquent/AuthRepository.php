<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\FcmToken;
use App\Repositories\Interfaces\IAuthRepository;

class AuthRepository implements IAuthRepository
{
    protected $fcmtokenmodel;
    protected $model;

    public function __construct(User $model, FcmToken $fcmtokenmodel)
    {
        $this->model = $model;
        $this->fcmtokenmodel = $fcmtokenmodel;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        $record->delete();
    }

    public function saveFcmToken(array $data)
    {
        $user = auth()->user();
//        $user = $this->model->findOrFail($data['user_id']);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $this->fcmtokenmodel->updateOrCreate(
            ['token' => $data->token],
            [
                'user_id' => $user->id,
                'device_info' => $data->device_info,
            ]
        );
        return response()->json(['message' => 'Token saved']);
    }
}
