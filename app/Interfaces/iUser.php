<?php

namespace App\Interfaces;

interface iUser 
{
    public function find(int $id);
    public function withdrawBalance(int $id, float $value);
    public function increaseBalance(int $id, float $value);
}