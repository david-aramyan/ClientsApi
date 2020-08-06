<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Client\ClientRepository;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * @var $clientRepository
     */
    protected $clientRepository;

    /**
     * ClientController constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->middleware('auth:api');
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $client = $this->clientRepository->getClient($id);
        return response()->json(['success' =>  $client ], Response::HTTP_OK);
    }

    /**
     * Store a newly created client.
     *
     * @param ClientRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $client = $this->clientRepository->createCLient($request->all());
        return response()->json(['success' =>  $client ] ,Response::HTTP_CREATED );
    }

    /**
     * Update the specified client .
     *
     * @param  int  $id
     * @param ClientRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id , ClientRequest $request)
    {
        $client = $this->clientRepository->updateClient($id, $request->all());
        return response()->json(['success' =>  $client], Response::HTTP_OK);
    }

    /**
     * Remove the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->clientRepository->deleteClient($id);
        return response()->json(null , Response::HTTP_NO_CONTENT);
    }

    /**
     * Search for the specified client.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchClient()
    {
        return response()->json(['success' => $this->clientRepository->searchClient()], Response::HTTP_OK);
    }
}
