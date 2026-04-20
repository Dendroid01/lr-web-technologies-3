<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GuestBookMessage;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guest_book_messages', function (Blueprint $table) {
            $table->string('message_hash', 64)->nullable()->unique()->after('message');
        });

        $messages = GuestBookMessage::all();
        foreach ($messages as $message) {
            $message->message_hash = hash('sha256', $message->message);
            $message->saveQuietly();
        }

        Schema::table('guest_book_messages', function (Blueprint $table) {
            $table->string('message_hash', 64)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('guest_book_messages', function (Blueprint $table) {
            $table->dropColumn('message_hash');
        });
    }
};
