<?php

namespace GL\Support\Database\Eloquent;

use Ramsey\Uuid\Uuid;

class UuidModel extends PreIdentifiedModel
{
    /**
     * generate identifier
     *
     * @return string
     */
    protected function genIdentifier()
    {
        return Uuid::uuid4()->toString();
    }
}