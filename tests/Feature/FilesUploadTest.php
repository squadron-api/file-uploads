<?php

namespace Squadron\FileUploads\Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile as LaravelUploadedFile;
use Squadron\FileUploads\Tests\TestCase;

class FilesUploadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('squadron.fileUploads.storeToDisk'));
    }

    public function testFileUpload(): void
    {
        $image = LaravelUploadedFile::fake()->image('image-1.jpg');

        $response = $this->post('/api/file/upload', ['file' => $image]);
        $response
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonCount(1, 'files');
    }

    public function testMultipleFilesUpload(): void
    {
        $images = [
            LaravelUploadedFile::fake()->image('image-1.jpg'),
            LaravelUploadedFile::fake()->image('image-2.jpg'),
            LaravelUploadedFile::fake()->image('image-3.png'),
        ];

        $response = $this->post('/api/file/upload', ['files' => $images]);
        $response
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonCount(3, 'files');
    }
}
