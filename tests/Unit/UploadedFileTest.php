<?php

namespace Squadron\FileUploads\Tests\Feature;

use Illuminate\Http\UploadedFile as LaravelUploadedFile;
use Squadron\FileUploads\Exceptions\SquadronFileUploadsException;
use Squadron\FileUploads\Tests\TestCase;
use Squadron\FileUploads\Models\UploadedFile;

class UploadedFileTest extends TestCase
{
    public function testInvalidExtensionFile(): void
    {
        $this->expectException(SquadronFileUploadsException::class);

        (new UploadedFile())->setFile(
            LaravelUploadedFile::fake()->create('invalid-file.php')
        );
    }

    public function testInvalidFile(): void
    {
        $this->expectException(SquadronFileUploadsException::class);

        (new UploadedFile())->setFile(new \stdClass());
    }

    public function testValidFiles(): void
    {
        $this->expectNotToPerformAssertions();

        $files = [
            LaravelUploadedFile::fake()->image('valid-file-1.jpg'),
            LaravelUploadedFile::fake()->image('valid-file-2.png'),
            LaravelUploadedFile::fake()->image('valid-file-3.jpeg'),
        ];

        foreach ($files as $file)
        {
            (new UploadedFile())->setFile($file);
        }
    }
}
