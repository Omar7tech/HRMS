<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('UUID()'));
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id');
            $table->string('nationality');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->decimal('salary', 10, 2);
            $table->string('emergency_contact');
            $table->string('cv')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->unsignedBigInteger('position_id'); // Define foreign key column
            $table->smallInteger('training')->default(0);
            $table->date("start_date")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
