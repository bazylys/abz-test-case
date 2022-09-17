<?php

namespace App\Repositories;

use App\Interfaces\PositionsRepositoryInterface;
use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

class PositionsRepository implements PositionsRepositoryInterface
{
    public function getAllPositions(): Collection|array
    {
        return Position::query()->get();
    }
}
