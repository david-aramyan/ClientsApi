<?php

namespace App\Repositories\Client;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ClientRepositoryService implements ClientRepository
{
    /**
     * @var $client
     */
    protected $client;

    /**
     * ClientRepositoryService constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get Client by id.
     *
     * @param int $id
     *
     * @return Client
     */
    public function getClient(int $id): Client
    {
        Log::info("Client selected by user with the ID: ".auth()->user()->id);
        return $this->client->with(['emails','phoneNumbers'])->findOrFail($id);
    }

    /**
     * Create a new Client.
     *
     * @param array $data
     *
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $data["emails"]        = array_unique($data["emails"]);
        $data["phone_numbers"] = array_unique($data["phone_numbers"]);

        $max = (count($data["phone_numbers"]) > count($data["emails"])) ? count($data["phone_numbers"]) : count($data["emails"]) ;

        for($i = 0; $i < $max; $i++) {
            if (!empty($data["emails"][$i])) $emails[]["email"] = $data["emails"][$i];
            if (!empty($data["phone_numbers"][$i])) $phones[]["number"] = $data["phone_numbers"][$i];
        }
        $client = $this->client->create(['name' => $data['name'], 'lastname' => $data['lastname']]);
        $client->emails()->createMany($emails);
        $client->phoneNumbers()->createMany($phones);

        Log::info("Client created by user with the ID: ".auth()->user()->id);
        return $client->load(['emails','phoneNumbers']);
    }

    /**
     * Update Client by id.
     *
     * @param int $id
     * @param array $data
     *
     * @return Client
     */
    public function updateClient(int $id, array $data): Client
    {
        $data["emails"]        = array_unique($data["emails"]);
        $data["phone_numbers"] = array_unique($data["phone_numbers"]);

        $max = (count($data["phone_numbers"]) > count($data["emails"])) ? count($data["phone_numbers"]) : count($data["emails"]) ;

        for($i = 0; $i < $max; $i++) {
            if (!empty($data["emails"][$i])) $emails[]["email"] = $data["emails"][$i];
            if (!empty($data["phone_numbers"][$i])) $phones[]["number"] = $data["phone_numbers"][$i];
        }

        $client = $this->client->findOrFail($id);
        $client->update(['name' => $data['name'], 'lastname' => $data['lastname']]);
        $client->emails()->delete();
        $client->phoneNumbers()->delete();
        $client->emails()->createMany($emails);
        $client->phoneNumbers()->createMany($phones);

        Log::info("Client updated by user with the ID: ".auth()->user()->id);
        return $client->load(['emails','phoneNumbers']);
    }

    /**
     * Delete Client by id.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteClient(int $id): void
    {
        Log::info("Client deleted by user with the ID: ".auth()->user()->id);
        $this->client->findOrFail($id)->delete();
    }

    /**
     * Search client.
     *
     * @return Collection
     */
    public function searchClient() : Collection
    {
        /** @var $clients Collection */
        $clients = new Collection();

        if ( request()->name && request()->lastname && request()->email && request()->phone ) {
            $clients = $this->client->where('name', request()->name)->where('lastname', request()->lastname)
                ->whereHas('phoneNumbers',function ($query) {
                    $query->where('number', request()->phone);
                })
                ->whereHas('emails',function ($query) {
                    $query->where('email', request()->email);
                })
                ->with('phoneNumbers','emails')->get();
        }
        elseif (request()->name && request()->lastname) {
            $clients = $this->client->where('name', request()->name)->where('lastname', request()->lastname)->with('phoneNumbers','emails')->get();
        }
        elseif (request()->phone) {
            $clients = $this->client->whereHas('phoneNumbers',function ($query) {
                $query->where('number', request()->phone);
            })->with(['phoneNumbers', 'emails'])->get();
        }
        elseif (request()->email) {
            $clients = $this->client->whereHas('emails',function ($query) {
                $query->where('email', request()->email);
            })->with(['phoneNumbers', 'emails'])->get();
        }
        Log::info("Client searched by user with the ID: ".auth()->user()->id);
        return $clients;
    }
}
