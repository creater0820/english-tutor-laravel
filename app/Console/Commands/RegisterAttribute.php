<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Category;
use App\Model\Tag;

class RegisterAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RegisterAttribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $attribute = [
            [
                'name' => '英語',
                'tags' => [
                    '英会話',
                    'ビジネス英語',
                    'TOEIC対策',
                    '英文添削',
                    '大学受験英語',
                    '英ネイティブ',
                    '米ネイティブ',
                ],
            ],
            [
                'name' => '大学受験',
                'tags' => [
                    '英語',
                    '数学',
                    '物理',
                    '化学',
                    '現代文',
                    '日本史',
                    '世界史',
                ],
            ],
            [
                'name' => '文系資格',
                'tags' => [
                    '日商簿記検定',
                    '税理士',
                    '行政書士',
                    '司法書士',
                    '宅地建物取引士',
                    '弁護士',
                    '社会保険労務士',
                ],
            ],
            [
                'name' => '理系資格',
                'tags' => [
                    '弁理士',
                    '税理士',
                    '行政書士',
                    '司法書士',
                    '宅地建物取引士',
                    '危険物取扱者',
                    '社会保険労務士',
                ],
            ],
            [
                'name' => 'IT資格',
                'tags' => [
                    '基本情報技術者',
                    '応用情報技術者',
                    'ITパスポート',
                    '司法書士',
                    '宅地建物取引士',
                    '危険物取扱者',
                    '社会保険労務士',
                ],
            ],
        ];
        foreach ($attribute as $category) {
            $categories = Category::where('name', $category['name'])->first();
            if (empty($categories->id)) {
                $categories = new Category();
                $categories->name = $category['name'];
                $categories->save();
            }
            foreach ($category['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->where('category_id',$categories->id)->first();
                if(empty($tag->id)){
                    $tag =  new Tag();
                    $tag->category_id = $categories->id;
                    $tag->name = $tagName;
                    $tag->save();
                }
            }
        }
        return 0;
    }
}
