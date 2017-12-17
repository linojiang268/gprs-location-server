<?php
namespace Tests\GL\Support\Repositories\Activity;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\GL\TestCase;

class ChinaMobileRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    //=========================================
    //           Find China Mobiles
    //=========================================
    public function testFindChinaMobiles()
    {
        $this->assertEquals([], $this->getRepository()->findChinaMobiles([
            ['lac' => '', 'cell_id' => ''],
        ]));
    }

    /**
     * @return \GL\Models\BaseStation\ChinaMobileRepository
     */
    private function getRepository()
    {
        return $this->app[\GL\Models\BaseStation\ChinaMobileRepository::class];
    }
}
