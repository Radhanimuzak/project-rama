<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leadsdata', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable(); // customer person name
            $table->string('sales_name')->nullable(); // sales person name
            $table->string('contact_number')->unique(); // phone number customer
            $table->string('product')->nullable(); // product name
            $table->string('status')->default('waiting'); // waiting, approved, rejected, follow_up
            $table->string('source_leads')->nullable(); // facebook, instagram, website, referral
            $table->text('note')->nullable()->nullable(); // notes about the lead
            $table->string('method')->nullable(); // gmeet, zoom, call, meetup
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadsdata');
    }
};