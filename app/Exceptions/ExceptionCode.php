<?php

namespace GL\Exceptions;

/**
 * global exception code definitions
 *
 */
final class ExceptionCode 
{
    /**
     * Code for general exception. When a general exception is received, nothing more
     * can be done but show the error message.
     * 
     * @var int
     */
    const GENERAL = 10000;

    const INVALID_PARAMS = 10001;

    const NOT_EXISTS_BASE_STATION = 10002;
}
