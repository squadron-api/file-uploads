<?php

namespace Squadron\FileUploads\Exceptions;

class SquadronFileUploadsException extends \Exception
{
    public static function invalidFile(): SquadronFileUploadsException
    {
        return new self('Invalid file', 400);
    }
}
