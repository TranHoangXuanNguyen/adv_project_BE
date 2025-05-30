<?php

namespace App\Repositories\Interfaces;

use PhpParser\Builder\Interface_;

Interface INotifyRepository
{
    public function getNotifyById(int $id);
}
