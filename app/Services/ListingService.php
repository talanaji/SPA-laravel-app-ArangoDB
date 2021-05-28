<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ListingRepositoryInterface;

class ListingService
{
    /**
     * ListingService variable
     *
     * @var [listingRespository]
     */
    protected $listRepository;

    /**
     * Constructor function
     *
     * @param ListingRepositoryInterface  $listRepository
     */
    public function __construct(ListingRepositoryInterface  $listRepository)
    {
        $this->listRepository = $listRepository;
    }
 
    /**
     * delete function
     *
     * @param [int] $id
     * @return void
     */
    public function deleteById($id)
    {
        $list = $this->listRepository->delete($id);
        return $list;
    }

    /**
     * getAll function
     * return all data
     *
     * @return void
     */
    public function getAll()
    {
        return $this->listRepository->getAll();
    }

    /**
     * getById function
     *
     * return specific list
     *
     * @param [int] $id
     * @return void
     */
    public function getById($id)
    {
        return $this->listRepository->getById($id);
    }

    /**
     * updateListing function
     *
     * @param [array] $data
     * @param [int] $id
     * @return void
     */
    public function updateListing($data, $id)
    {
        $list = $this->listRepository->update($data, $id);
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
        $result = $this->listRepository->save($data);
        $result = $this->getAll();
        return $result;
    }
}
