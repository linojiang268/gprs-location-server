<?php

namespace GL\Exceptions;


class NotExistsBaseStationException extends AppException
{
    public function __construct($message = 'Base station is not exists.', $code = ExceptionCode::NOT_EXISTS_BASE_STATION)
    {
        parent::__construct($message, $code);
    }
}