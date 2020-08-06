<?php

namespace App\Repositories\Client;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepository
{
    public function getClient(int $id): Client;
    public function createClient(array $data): Client;
    public function updateClient(int $id, array $data): Client;
    public function deleteClient(int $id): void;
    public function searchClient(): Collection;
}
