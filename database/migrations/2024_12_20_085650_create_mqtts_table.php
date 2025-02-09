<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

        /**
         * Run the migrations.
         */
        public function up()
        {
            Schema::create('mqtt_users', function (Blueprint $table) {
                $table->id();
                $table->string('mqtt_id')->unique();
                $table->string('password');
                $table->string('topic');
                $table->unsignedBigInteger('user_id'); // Menambahkan kolom user_id
                $table->timestamps();
    
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
            });
        }
        
    
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('mqtt_users');
        }
    };
