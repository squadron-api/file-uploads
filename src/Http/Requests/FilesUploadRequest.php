<?php

namespace Squadron\FileUploads\Http\Requests;

use Squadron\Base\Http\Requests\BaseRequest;

class FilesUploadRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => 'required_without:files|file',
            'files' => 'required_without:file|array',
            'files.*' => 'file',
        ];
    }
}
