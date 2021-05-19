<?php

namespace App\Services;

use App\Repositories\ListingRepository;
use Illuminate\Support\Facades\Log;
use \DB;

use Illuminate\Support\Facades\Validator;

class ListingService
{
    protected $listRepository;

    public function __construct(ListingRepository $listRepository)
    {
        $this->listRepository = $listRepository;
    } 
 
    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $list = $this->listRepository->delete($id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete list data');
        }

        DB::commit();

        return $list;

    }

   
    public function getAll()
    {
        return $this->listRepository->getAll();
    }

 
    public function getById($id)
    {
        return $this->listRepository->getById($id);
    }

 
    public function updateListing($data, $id)
    {
          
        $validator = Validator::make($data, [
            'title' => 'required|min:2',
            'email' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
           
            $list = $this->listRepository->update($data, $id);
         
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update list data');
        }

        DB::commit();

        return $list;

    }

    /**
     * Validate list data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveListingData($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->listRepository->save($data);
        $result= $this->getAll();
        return $result;
    }

}