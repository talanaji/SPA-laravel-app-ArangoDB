<?php



namespace Tests\Unit;

use App\Helpers\ArangoDBConn;
use App\Http\Controllers\ListingsController;
use App\Models\Listings;
use App\Repositories\ListingRepositoryInterface;
use App\Services\ListingService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListingControllerTest extends TestCase
{
    public function testGetListById()
    {
        $listingRepositoryMock = \Mockery::mock('App\Repositories\ListingRepositoryInterface');
        $listingRepositoryMock->shouldReceive('getById')->withSomeOfArgs(1)->andReturn(new Listings());
    
        $listingService = new ListingService($listingRepositoryMock);
        $this->assertEquals(new Listings(), $listingService->getById(1));
    }

    public function testGetAllList()
    {
        $listingRepositoryMock = \Mockery::mock('App\Repositories\ListingRepositoryInterface');
        $listingRepositoryMock->shouldReceive('getAll')->andReturn([new Listings()]);

        $listingService = new ListingService($listingRepositoryMock);
        $this->assertEquals([new Listings()], $listingService->getAll());
    }
    public function testDeleteList()
    {
        $listingRepositoryMock = \Mockery::mock('App\Repositories\ListingRepositoryInterface');
        $listingRepositoryMock->shouldReceive('delete')->withSomeOfArgs(1)->andReturn([new Listings()]);

        $listingService = new ListingService($listingRepositoryMock);
        $this->assertEquals([new Listings()], $listingService->deleteById(1));
    }

    public function testSaveList()
    {
        $list = [
            'title' => 'Test List',
            'price' => '100',
            'area' => 'Ovik',
            'address' => 'Nygatan',
            'name' => 'Tala',
            'email' => 'test@test.com',
            'phoneNumber' => '0777777777',
        ];

        $listingRepositoryMock = \Mockery::mock('App\Repositories\ListingRepositoryInterface');
        $listingRepositoryMock->shouldReceive('save')->withSomeOfArgs($list)->andReturn([new Listings()]);
    
        $listingService = new ListingService($listingRepositoryMock);
        $this->assertEquals([new Listings()], $listingService->saveListingData($list));
    }
    public function testUpdateList()
    {
        $list = [
            'title' => 'Test List',
            'price' => '100',
            'area' => 'Ovik',
            'address' => 'Nygatan',
            'name' => 'Tala',
            'email' => 'test@test.com',
            'phoneNumber' => '0777777777',
        ];

        $listingRepositoryMock = \Mockery::mock('App\Repositories\ListingRepositoryInterface');
        $listingRepositoryMock->shouldReceive('update')->withSomeOfArgs($list, 1)->andReturn([new Listings()]);
    
        $listingService = new ListingService($listingRepositoryMock);
        $this->assertEquals([new Listings()], $listingService->updateListing($list, 1));
    }
}
