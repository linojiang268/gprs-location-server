<?php

namespace Tests\GL\Http\Controllers\Home;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\GL\TestCase;

class BaseStationControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    //=========================================
    //               Location
    //=========================================
    public function testLocation()
    {
//        $user = factory(User::class)->create();
//        /** @var Dealer $dealer */
//        $dealer = factory(Dealer::class)->create();
//        factory(Order::class)->create([
//            'user_id'   => $user->id,
//            'dealer_id' => $dealer->id,
//            'status'    => Order::STATUS_FINISH,
//        ]);
//
//        $response = $response = $this->actingAs($user)
//            ->json('GET', 'api/home_page_data',
//                [], $this->morphJwtTokenHeader($user));
//
//        $this->seeJsonResponseOk($response);
//        $response->assertJsonStructure([
//            'data' => [
//                'title',
//                'button_status' => [
//                    'un_finished', 'pending_pay', 'pending_evaluated', 'finished',
//                ],
//            ]
//        ]);
        $response = $this->getJson('api/base_station/location');
        $response->assertSuccessful();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(0, $data['status']);
//        $this->assertEquals(0, $data['lat']);
//        $this->assertEquals(0, $data['lon']);
//        $this->assertEquals(0, $data['address']);
    }
}
