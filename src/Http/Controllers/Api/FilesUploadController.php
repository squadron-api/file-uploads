<?php

namespace Squadron\FileUploads\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Squadron\Base\Helpers\ApiResponse;
use Squadron\Base\Http\Controllers\BaseController;
use Squadron\FileUploads\Exceptions\SquadronFileUploadsException;
use Squadron\FileUploads\Http\Requests\FilesUploadRequest;
use Squadron\FileUploads\Models\UploadedFile;

class FilesUploadController extends BaseController
{
    /**
     * @param FilesUploadRequest $request
     *
     * @throws SquadronFileUploadsException
     *
     * @return JsonResponse
     */
    public function upload(FilesUploadRequest $request): JsonResponse
    {
        // get request files
        $uploadedFiles = [];

        $files = $request->allFiles();
        $files = $files['files'] ?? [$files['file']];

        // try to save them
        foreach ($files as $file)
        {
            $uploadedFile = (new UploadedFile())->setFile($file);
            $uploadedFile->save();

            if ($uploadedFile->exists)
            {
                $uploadedFiles[] = $uploadedFile->getKey();
            }
        }

        // return array of file UUIDs
        return ApiResponse::success(__('squadron.fileUploads::messages.uploadSuccess'), [
            'files' => $uploadedFiles,
        ]);
    }
}
