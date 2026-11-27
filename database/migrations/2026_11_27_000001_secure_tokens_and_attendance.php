<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereNotNull('api_token')
            ->orderBy('id')
            ->chunkById(100, function ($users) {
                $exampleTokens = array_map(
                    fn ($id) => sprintf('example-api-token-user-%02d', $id),
                    range(1, 25)
                );
                $exampleTokens[] = 'example-api-token-schedule-bot';

                foreach ($users as $user) {
                    if (in_array($user->api_token, $exampleTokens, true)) {
                        DB::table('users')->where('id', $user->id)->update(['api_token' => null]);
                        continue;
                    }

                    if (preg_match('/^[a-f0-9]{64}$/', $user->api_token)) {
                        continue;
                    }

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['api_token' => hash('sha256', $user->api_token)]);
                }
            });

        $duplicates = DB::table('attendance')
            ->selectRaw('MIN(id) AS keep_id, session_id, user_id')
            ->groupBy('session_id', 'user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('attendance')
                ->where('session_id', $duplicate->session_id)
                ->where('user_id', $duplicate->user_id)
                ->where('id', '<>', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('attendance', function (Blueprint $table) {
            $table->unique(['session_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'user_id']);
        });
    }
};
