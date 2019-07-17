<?php

namespace Squadron\FileUploads\Policies;

class UploadedFilePolicy
{
    public function upload($currentUser = null): bool
    {
        return true;
    }
}
