<?php
namespace App\Repositories\Interfaces;

interface IClassRepository {
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public  function getAllClasses();
    public function addStudentToClass(int $id,array $data);
    public function saveClassPlan(array $data);

    public function getClassInfor(int $id);

    public function getClassById(int $it);
}
