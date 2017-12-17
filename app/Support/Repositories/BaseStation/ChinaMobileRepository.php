<?php
namespace GL\Support\Repositories\BaseStation;

use GL\Models\BaseStation\ChinaMobileRepository as ChinaMobileRepositoryConstract;

class ChinaMobileRepository implements ChinaMobileRepositoryConstract
{
    /**
     * {@inheritdoc}
     */
    public function findChinaMobiles(array $params)
    {
        return [];
    }
}
