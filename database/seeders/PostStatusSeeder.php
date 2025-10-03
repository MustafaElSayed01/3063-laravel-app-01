<?php

namespace Database\Seeders;

use App\Models\PostStatus;
use Illuminate\Database\Seeder;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post_statuses_types = [
            'active',
            'inactive',
            'archived',
            'deleted',
            'pending',
            'rejected',
            'approved',
        ];

        foreach ($post_statuses_types as $type) {
            PostStatus::create([
                'type' => $type,
            ]);
        }
    }
}
