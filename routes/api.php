<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Squadron\FileUploads\Http\Controllers\Api')
    ->prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::post('/file/upload', 'FilesUploadController@upload')
            ->middleware('can:upload,Squadron\FileUploads\Models\UploadedFile')
            ->name('squadron.files.upload');
    });
