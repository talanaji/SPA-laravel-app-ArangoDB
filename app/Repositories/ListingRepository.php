<?php

namespace App\Repositories;

use App\Helpers\ArangoDBConnInterface;

use App\Models\Listings;

use ArangoDBClient;
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\DocumentHandler as ArangoDocumentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Repositories\ListingRepositoryInterface;

class ListingRepository implements ListingRepositoryInterface
{
    /**
    * @var ListingRepository
    */
    protected $list;
    protected $conn;
    
    /**
     * ListingRepository constructor.
     *
     * @param Listing $list
     */
    public function __construct(Listings $list, ArangoDBConnInterface $helper)
    {
        $this->list = $list;
        $this->conn = $helper->conn();
    }

    /**
     * Get all Listings.
     *
     * @return Listing $list
     */
    public function getAll()
    {
        $collectionHandler = new ArangoCollectionHandler($this->conn);

        $cursor = $collectionHandler->byExample('listings', []);
        return $cursor->getAll();
    }

    /**
     * Get list by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $handler = new ArangoDocumentHandler($this->conn);
        return $userFromServer = $handler->get('listings', $id);
    }

    /**
     * Save Listing
     *
     * @param $data
     * @return Listing
     */
    public function save($data)
    {
        $handler = new ArangoDocumentHandler($this->conn);

        // create a new document
        $list = new ArangoDocument();
        
        // use set method to set document properties
        $list->set('title', $data['title']);
        $list->set('price', $data['price']);
        $list->set('area', $data['area']);
        $list->set('address', $data['address']);
        $list->set('name', $data['name']);
        $list->set('email', $data['email']);
        $list->set('phoneNumber', $data['phoneNumber']);
         
        
        // send the document to the server
        $id = $handler->save('listings', $list);
         

        return $list->getId();
    }

    /**
     * Update Listing
     *
     * @param $data
     * @return Listing
     */
    public function update($data, $id)
    {
        //print_r($this->conn);exit;
        $handler = new ArangoDocumentHandler($this->conn);

        $list = new ArangoDocument();
        // $list = $handler->get('listings', $id);

        // = $this->list->where('_key', $id)->get();
        $list->title = $data['title'];
        $list->price = (int)$data['price'];
        $list->area = $data['area'];
        $list->address = $data['address'];
        $list->name = $data['name'];
        $list->email = $data['email'];
        $list->phoneNumber = $data['phoneNumber'];
        $result = $handler->updateById('listings', $id, $list);//update($list);
        
        $list = $handler->get('listings', $id);
        return $this->getAll();
    }


    /**
     * DELEE Listing
     *
     * @param $data
     * @return Listing
     */
    public function delete($id)
    {
        $handler = new ArangoDocumentHandler($this->conn);
        $listFromServer = $handler->get('listings', $id);
        $result = $handler->remove($listFromServer);
        return $this->getAll();
    }
}
