<?php

namespace App\Interfaces;

interface PlayerRepositoryInterface
{
    public function all();
    public function get($teamId);
    public function delete($teamId);
    public function create(array $teamDetails);
    public function update($orderId, array $teamDetails);
}
