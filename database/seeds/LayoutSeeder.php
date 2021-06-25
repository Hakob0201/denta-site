<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$layouts = [
			['layout_type' => 'article', 'layout_key' => 'article', 'layout_name' => ['hy' => 'Standart', 'en' => 'Standart', 'ru' => 'Standart']],
			['layout_type' => 'article', 'layout_key' => 'article', 'layout_name' => ['hy' => 'Minimal', 'en' => 'Minimal', 'ru' => 'Minimal']],
			['layout_type' => 'article', 'layout_key' => 'article', 'layout_name' => ['hy' => 'Parallax', 'en' => 'Parallax', 'ru' => 'Parallax']],
			['layout_type' => 'article', 'layout_key' => 'photo', 'layout_name' => ['hy' => 'Photo', 'en' => 'Photo', 'ru' => 'Фото']],
			['layout_type' => 'article', 'layout_key' => 'video', 'layout_name' => ['hy' => 'Video', 'en' => 'Video', 'ru' => 'Видео']],
            ['layout_type' => 'article', 'layout_key' => 'audio', 'layout_name' => ['hy' => 'Podcast', 'en' => 'Podcast', 'ru' => 'Podcast']],
            ['layout_type' => 'category', 'layout_key' => 'article', 'layout_name' => ['hy' => 'Լուրեր', 'en' => 'Article', 'ru' => 'Статья']],
            ['layout_type' => 'category', 'layout_key' => 'photo', 'layout_name' => ['hy' => 'Photo', 'en' => 'Photo', 'ru' => 'Фото']],
			['layout_type' => 'category', 'layout_key' => 'video', 'layout_name' => ['hy' => 'Տեսանյութեր', 'en' => 'Video', 'ru' => 'Видео']],
            ['layout_type' => 'category', 'layout_key' => 'audio', 'layout_name' => ['hy' => 'Podcast', 'en' => 'Podcast', 'ru' => 'Podcast']],
			['layout_type' => 'category', 'layout_key' => 'custom', 'layout_name' => ['hy' => 'Տնտեսական', 'en' => 'Economic', 'ru' => 'Экономика']],
		];

		foreach ($layouts as $lay) {
			DB::table('layouts')->insert([
				'layout_name' => json_encode($lay['layout_name'], JSON_UNESCAPED_UNICODE),
				'layout_key' => $lay['layout_key'],
				'layout_type' => $lay['layout_type'],
				'onoff'       => 1,
				"created_at"  => \Carbon\Carbon::now(),
				"updated_at"  => \Carbon\Carbon::now(),
			]);
		}

	}
}
