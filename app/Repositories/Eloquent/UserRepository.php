<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
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

    public function getByRole(string $role)
    {
        return $this->model->where('role', $role)->get()->toArray();
    }

    public function paginatedByRole(string $role, int $perpage){
        return User::where('role', $role)->paginate($perpage);
    }
    public function deletedById(int $id){
        $user=User::findOrFail($id);
          \DB::table('student_in_class')->where('user_id', $id)->delete();

        $user->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}   
