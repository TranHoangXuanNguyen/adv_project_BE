<?php
namespace App\Repositories\Interfaces;

interface ISemesterRepository
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function getLastestSemester($classId);

    public function storeBySemester(int $id,array $data);

    public function getSubjectsBySemester(int $id);

}
