<?php

namespace Tests\GL\Http\Controllers\Home;

use GL\Exceptions\ExceptionCode;
use GL\Models\BaseStation\ChinaMobile;
use GL\Models\BaseStation\ChinaTelecom;
use GL\Models\BaseStation\ChinaUnicom;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\GL\TestCase;

class BaseStationControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    //=========================================
    //               Location
    //=========================================
    public function testLocation_NotExists()
    {
        factory(ChinaMobile::class)->create();
        $response = $this->getJson('api/base_station/location?mnc=0&lac=0&cell_id=0');
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(ExceptionCode::NOT_EXISTS_BASE_STATION, $data['status']);
    }

    public function testLocation_ChinaMoibleExists()
    {
        /** @var ChinaMobile $chinaMobile */
        $chinaMobile = factory(ChinaMobile::class)->create();
        $response = $this->getJson(sprintf('api/base_station/location?mnc=%s&lac=%s&cell_id=%s', 0, $chinaMobile->lac, $chinaMobile->cellId));
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(0, $data['status']);
        $this->assertEquals($chinaMobile->lat, $data['lat']);
        $this->assertEquals($chinaMobile->lon, $data['lon']);
        $this->assertEquals($chinaMobile->radius, $data['radius']);
        $this->assertEquals($chinaMobile->address, $data['address']);
    }

    public function testLocation_ChinaUnicomExists()
    {
        /** @var ChinaUnicom $chinaUnicom */
        $chinaUnicom = factory(ChinaUnicom::class)->create();
        $response = $this->getJson(sprintf('api/base_station/location?mnc=%s&lac=%s&cell_id=%s', 1, $chinaUnicom->lac, $chinaUnicom->cellId));
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(0, $data['status']);
        $this->assertEquals($chinaUnicom->lat, $data['lat']);
        $this->assertEquals($chinaUnicom->lon, $data['lon']);
        $this->assertEquals($chinaUnicom->radius, $data['radius']);
        $this->assertEquals($chinaUnicom->address, $data['address']);
    }

    public function testLocation_ChinaTelecomExists()
    {
        /** @var ChinaTelecom $chinaTelecom */
        $chinaTelecom = factory(ChinaTelecom::class)->create();
        $response = $this->getJson(sprintf('api/base_station/location?mnc=%s&sid=%s&nid=%s&bid=%s', 2, $chinaTelecom->sid, $chinaTelecom->nid, $chinaTelecom->bid));
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(0, $data['status']);
        $this->assertEquals($chinaTelecom->lat, $data['lat']);
        $this->assertEquals($chinaTelecom->lon, $data['lon']);
        $this->assertEquals($chinaTelecom->radius, $data['radius']);
        $this->assertEquals($chinaTelecom->address, $data['address']);
    }

    //=========================================
    //               Locations
    //=========================================
    public function testLocations_ChinaMoibleExists()
    {
        $chinaMobiles = [
            factory(ChinaMobile::class)->create(),
            factory(ChinaMobile::class)->create(),
            factory(ChinaMobile::class)->create(),
        ];
        $response = $this->getJson(sprintf('api/base_stations/location?mnc=%s&multi=%s', 0, json_encode([
            ['lac' => $chinaMobiles[0]->lac, 'cell_id' => $chinaMobiles[0]->cell_id, 'rx_level' => -20],
            ['lac' => $chinaMobiles[1]->lac, 'cell_id' => $chinaMobiles[1]->cell_id, 'rx_level' => -50],
        ])));
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(0, $data['status']);
        $this->assertEquals(32.073867, $data['lat']);
        $this->assertEquals(108.036614, $data['lon']);
    }
}
