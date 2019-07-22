<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\Http\Requests\Api\CreateContract;
use App\Social\Transformers\ContractTransformer;
use App\Social\Sign\AdobeSign;

class ContractController extends ApiController
{
    /**
     * ContractController constructor.
     *
     * @param ContractTransformer $transformer
     */
    public function __construct(ContractTransformer $transformer)
    {
        $this->transformer= $transformer;

        //$this->middleware('auth.api')->except(['index', 'show']);
        //$this->middleware('auth.api:optional')->only(['index', 'show']);
    }

    /**
     * Get all the contract.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $contracts = Contract::all();

        return $this->respondWithTransformer($contracts);
    }

    /**
     * Create a new Contract and return it if successful.
     *
     * @param CreateContract $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateContract $request)
    {
        $contract = new Contract();

        $contract = $contract->create([
            'artist_id' => $request->input('contract.artist_id'),
            'template_id' => $request->input('contract.template_id'),
            'song_id' => $request->input('contract.song_id'),
        ]);

        $data = Array();
        $data['email'] = $contract->artist->email;
        $data['real_name'] = $contract->artist->real_name;
        $data['artist_name'] = $contract->artist->artist_name;
        $data['address'] = $contract->artist->address;
        $data['deal_type'] = $contract->template->deal_type;
        $data['master_split'] = $contract->template->master_split;
        $data['publishing_split'] = $contract->template->publishing_split;

        $sign = new AdobeSign();

        //$sign->editDoc($data);
        //$sign->uploadDocumentToLibrary();
        $sign->sendToSign($data);

//        $templateProcessor->setValue('real_name', $data['real_name']);
//        $templateProcessor->setValue('artist_name', $data['artist_name']);
//        $templateProcessor->setValue('address', $data['address']);
//        $templateProcessor->setValue('deal_type', $data['deal_type']);
//        $templateProcessor->setValue('master_split', $data['master_split']);
//        $templateProcessor->setValue('publishing_split', $data['publishing_split']);


        return $this->respondWithTransformer($contract);
    }

    /**
     * Get the contract given by its id.
     *
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Contract $contract)
    {
        return $this->respondWithTransformer($contract);
    }
}
