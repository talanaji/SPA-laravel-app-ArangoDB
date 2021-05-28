<?php

namespace App\Repositories;
 

interface ListingRepositoryInterface
{
    /**
     * getAll function
     *
     * @return void all data
     */
    public function getAll();
    /**
     * getById function
     *
     * @param [int] $id
     * @return void specific list
     */
    public function getById($id);
    /**
     * save function
     *
     * @param [array] $data
     * @return void create new list
     */
    public function save($data);
    /**
     * update function
     *
     * @param [array] $data
     * @param [int] $id
     * @return void update sepecfic list
     */
    public function update($data, $id);
    /**
     * delete function
     *
     * @param [int] $id
     * @return void
     */
    public function delete($id) ;
}
