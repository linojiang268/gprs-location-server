<?php

namespace GL\Models\BaseStation;

interface ChinaMobileRepository
{
    /**
     * @param array $params  keys of item in array taken:
     *                        - lac
     *                        - cell_id
     * @return array  array of ChinaMobile
     */
    public function findChinaMobiles(array $params);
}