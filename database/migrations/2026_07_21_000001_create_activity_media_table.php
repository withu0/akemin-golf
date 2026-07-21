<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('type', 16); // image | video
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('cover_media_id')->nullable()->after('sort');
        });

        $activities = DB::table('activities')->select('id', 'cover_image', 'video')->get();

        foreach ($activities as $activity) {
            $coverMediaId = null;
            $sort = 0;

            if ($activity->cover_image) {
                $coverMediaId = DB::table('activity_media')->insertGetId([
                    'activity_id' => $activity->id,
                    'path'        => $activity->cover_image,
                    'type'        => 'image',
                    'sort'        => $sort++,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            if ($activity->video) {
                $videoId = DB::table('activity_media')->insertGetId([
                    'activity_id' => $activity->id,
                    'path'        => $activity->video,
                    'type'        => 'video',
                    'sort'        => $sort++,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                if ($coverMediaId === null) {
                    $coverMediaId = $videoId;
                }
            }

            if ($coverMediaId !== null) {
                DB::table('activities')->where('id', $activity->id)->update([
                    'cover_media_id' => $coverMediaId,
                ]);
            }
        }

        Schema::table('activities', function (Blueprint $table) {
            $table->foreign('cover_media_id')
                ->references('id')
                ->on('activity_media')
                ->nullOnDelete();
            $table->dropColumn(['cover_image', 'video']);
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('happened_on');
            $table->string('video')->nullable()->after('cover_image');
        });

        $activities = DB::table('activities')->select('id', 'cover_media_id')->get();

        foreach ($activities as $activity) {
            $media = DB::table('activity_media')
                ->where('activity_id', $activity->id)
                ->orderBy('sort')
                ->orderBy('id')
                ->get();

            $coverImage = null;
            $video = null;

            foreach ($media as $item) {
                if ($item->type === 'image' && $coverImage === null) {
                    $coverImage = $item->path;
                }
                if ($item->type === 'video' && $video === null) {
                    $video = $item->path;
                }
            }

            if ($activity->cover_media_id) {
                $cover = $media->firstWhere('id', $activity->cover_media_id);
                if ($cover?->type === 'image') {
                    $coverImage = $cover->path;
                } elseif ($cover?->type === 'video') {
                    $video = $cover->path;
                    // Prefer an image as cover_image if any exists; keep video in video column
                    $image = $media->firstWhere('type', 'image');
                    $coverImage = $image?->path;
                }
            }

            DB::table('activities')->where('id', $activity->id)->update([
                'cover_image' => $coverImage,
                'video'       => $video,
            ]);
        }

        Schema::table('activities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cover_media_id');
        });

        Schema::dropIfExists('activity_media');
    }
};
