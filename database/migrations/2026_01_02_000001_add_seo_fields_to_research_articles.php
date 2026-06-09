<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research_articles', function (Blueprint $table) {
            $table->string('keywords')->nullable()->after('meta_description');
            $table->json('key_takeaways')->nullable()->after('keywords');
            $table->json('faqs')->nullable()->after('key_takeaways');
        });
    }

    public function down(): void
    {
        Schema::table('research_articles', function (Blueprint $table) {
            $table->dropColumn(['keywords', 'key_takeaways', 'faqs']);
        });
    }
};
