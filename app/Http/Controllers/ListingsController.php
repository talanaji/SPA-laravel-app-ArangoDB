<?php

namespace App\Http\Controllers;

use App\Services\ListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListingsController extends Controller
{
    protected $listService;

    /**
     * ListingController Constructor
     *
     * @param ListingService $listService
     *
     */
    public function __construct(ListingService $listService)
    {
        $this->listService = $listService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->listService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'price',
            'area',
            'address',
            'name',
            'email',
            'phoneNumber'
        ]);
        $validator = Validator::make($data, [
            'title' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->errors()]);
        }
        $result = ['status' => 200];

        try {
            $result['data'] = $this->listService->saveListingData($data);
        } catch (Exception $e) {
            return response()->json(['status' => 'errors', 'errors' => $e->getMessage()]);
        }

        // return response()->json($result, $result['status']);
        return response()->json(['status' => 'success', 'data' => $result['data']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->listService->getById($id);
        } catch (Exception $e) {
            return response()->json(['status' => 'errors', 'errors' => $e->getMessage()]);
        }
        return response()->json(['status' => 'success', 'data' => $result['data']]);
    }

    
    /**
     * Update list.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'title',
            'price',
            'area',
            'address',
            'name',
            'email',
            'phoneNumber'
        ]);
        $validator = Validator::make($data, [
            'title' => 'required|min:2',
            'email' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->errors()]);
        }
        try {
            $result['data'] = $this->listService->updateListing($data, $id);
        } catch (Exception $e) {
            return response()->json(['status' => 'errors', 'errors' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'data' => $result['data']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->listService->deleteById($id);
        } catch (Exception $e) {
            return response()->json(['status' => 'errors', 'errors' => $e->getMessage()]);
        }
        return response()->json(['status' => 'success', 'data' => $result['data']]);
    }
}
