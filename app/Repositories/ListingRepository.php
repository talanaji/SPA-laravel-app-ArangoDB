<?php

namespace App\Repositories;
use ArangoDBClient;

use ArangoDBClient\DocumentHandler as ArangoDocumentHandler;

use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Document as ArangoDocument; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Listings;
use Illuminate\Support\Collection;
use \DB;
use App\Helper;

class ListingRepository
{
    /**
    * @var ListingRepository
    */
   protected $list;
   protected $helper; 
    
   /**
    * ListingRepository constructor.
    *
    * @param Listing $list
    */
   public function __construct(Listings $list,Helper $helper)
   {
    $this->list = $list;
    $this->helper = $helper;
   }

   /**
    * Get all Listings.
    *
    * @return Listing $list
    */
   public function getAll()
   {
       /*return $this->list
           ->get();*/
           $collectionHandler = new ArangoCollectionHandler($this->helper->conn());

           $cursor = $collectionHandler->byExample('listings', []);
           return $cursor->getAll();
          // return $handler->get('listings');
   }

   /**
    * Get list by id
    *
    * @param $id
    * @return mixed
    */
   public function getById($id)
   {
       return $this->list
           ->where('_key', $id)
           ->get();
   }

   /**
    * Save Listing
    *
    * @param $data
    * @return Listing
    */
   public function save($data)
   {
        $handler = new ArangoDocumentHandler($this->helper->conn());

        // create a new document
        $list = new ArangoDocument();
        
        // use set method to set document properties 
        $list->set('title',$data['title']);
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
        $list= new ArangoDocument();
       // $list = $handler->get('listings', $id); 

        // = $this->list->where('_key', $id)->get();
        $list->title = $data['title'];
        $list->price =  (int)$data['price'];
        $list->area = $data['area'];
        $list->address = $data['address'];
        $list->name = $data['name'];
        $list->email = $data['email'];
        $list->phoneNumber = $data['phoneNumber'];  
        $handler = new ArangoDocumentHandler($this->helper->conn());
        $result =  $handler->updateById('listings', $id, $list);//update($list);
        
        $list = $handler->get('listings', $id); 
       return $this->list
       ->get();
    }


   /**
    * DELEE Listing
    *
    * @param $data
    * @return Listing
    */
   public function delete($id)
   {
    try { 
        
        $handler = new ArangoDocumentHandler($this->helper->conn());
         $listFromServer =  $handler->get('listings', $id);

        $result =  $handler->remove($listFromServer);
        return $this->list
           ->get();
        
    } catch (ArangoConnectException $e) {
        print 'Connection error: ' . $e->getMessage() . PHP_EOL;
    } catch (ArangoClientException $e) {
        print 'Client error: ' . $e->getMessage() . PHP_EOL;
    } catch (ArangoServerException $e) {
        print 'Server error: ' . $e->getServerCode() . ':' . $e->getServerMessage() . ' ' . $e->getMessage() . PHP_EOL;
    }    
   }

}