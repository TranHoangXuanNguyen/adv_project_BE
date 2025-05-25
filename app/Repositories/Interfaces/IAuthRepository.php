<?php

namespace App\Repositories\Interfaces;

interface IAuthRepository
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function saveFcmToken(array $data);
    public function sendNotification(int $senderId,int $receiverId,string $content,int $week_id);
}
