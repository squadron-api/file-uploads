<?php

namespace Squadron\FileUploads\Models;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile as LaravelUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Squadron\Base\Models\BaseModel;
use Squadron\FileUploads\Exceptions\SquadronFileUploadsException;

/**
 * Class UploadedFile.
 *
 * @property string $path
 */
class UploadedFile extends BaseModel
{
    /** @var File|LaravelUploadedFile */
    protected $file;

    protected static function boot(): void
    {
        parent::boot();

        $storeFilesDisk = config('squadron.fileUploads.storeToDisk', '');

        static::creating(function ($model) use ($storeFilesDisk) {
            $model->{$model->getKeyName()} = (string) Str::uuid();

            $model->path = $model->file->store('/', $storeFilesDisk);
            unlink($model->file->getRealPath());
        });

        static::deleted(function ($model) use ($storeFilesDisk) {
            Storage::disk($storeFilesDisk)->delete($model->path);
        });

        static::retrieved(function ($model) use ($storeFilesDisk) {
            $pathPrefix = Storage::disk($storeFilesDisk)->getDriver()->getAdapter()->getPathPrefix();
            $model->file = new File(sprintf('%s/%s', $pathPrefix, $model->path));
        });
    }

    /**
     * Set file data for model.
     *
     * @param File|LaravelUploadedFile $file
     *
     * @throws SquadronFileUploadsException
     *
     * @return UploadedFile
     */
    public function setFile($file): UploadedFile
    {
        if (! $this->isFileValid($file))
        {
            throw SquadronFileUploadsException::invalidFile();
        }

        $this->file = $file;

        return $this;
    }

    /**
     * Get File.
     *
     * @return File|LaravelUploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Check file.
     *
     * @param File|LaravelUploadedFile $file
     *
     * @return bool
     */
    private function isFileValid($file): bool
    {
        if ($file instanceof File || $file instanceof LaravelUploadedFile)
        {
            return in_array($file->extension(), config('squadron.fileUploads.allowExtensions', []), true);
        }

        return false;
    }
}
