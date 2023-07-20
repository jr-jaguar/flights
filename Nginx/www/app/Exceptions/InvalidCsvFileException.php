<?php

namespace App\Exceptions;

use Exception;

class InvalidCsvFileException extends Exception
{
    protected $message = 'The CSV file has an invalid format.';
}
