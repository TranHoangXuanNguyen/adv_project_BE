<?php
namespace App\Repositories\Interfaces;

interface IClassRepository {
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getById(int $id);
    public  function getAllClasses();
    public function addStudentToClass(int $id,array $data);
    public function saveClassPlan(array $data);
}
