<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Squadron\Base\Helpers\Database\DatabaseSchema;

class FileUploads extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DatabaseSchema::create('uploaded_file', function (Blueprint $table) {
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('uploaded_file');
    }
}
