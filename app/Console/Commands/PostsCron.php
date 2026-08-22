<?php

namespace App\Console\Commands;

use App\Entity\Age;
use App\Entity\Category;
use App\Entity\Cron_posts;
use App\Entity\Input;
use App\Entity\Jobs_home;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Http\Controllers\Site\MailConfigController;
use App\Mail\TestEmail;
use Illuminate\Console\Command;

class PostsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhập tin tức theo ngày';

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
     * @return mixed
     */
    public function handle()
    {
        $slug_cate = 'tin-tuc';
        $postModel = new Post();
        $categoryModel = new Category();
        $category = $categoryModel->where('slug', $slug_cate)
            ->where('post_type', 'post')
            ->first();

        $posts = $postModel->join('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->select(
                'posts.title',
                'posts.post_id',
                'posts.slug',
                'posts.image',
                'posts.description'
            )
            ->where('category_post.category_id', $category->category_id)
            ->where('visiable', 0)
            ->offset(0)
            ->limit(10)
            ->orderBy('posts.post_id', 'desc')
            ->distinct()
            ->where('category_post.deleted_at', null)
            ->get();

        foreach ($posts as $id => $post) {
            $inputs = Input::where('post_id', $post->post_id)
                ->get();
            foreach ($inputs as $input) {
                $posts[$id][$input->type_input_slug] = $input->content;
            }
        }

        $cron_post = new Cron_posts();
        $delete_post = $cron_post->select('*')->delete();

        foreach($posts as $p)
        {
            $insert = $cron_post->insert([
                'slug_category' => $slug_cate,
                'title' => $p->title,
                'post_id' => $p->post_id,
                'post_slug' => $p->slug,
                'image'  => $p->image,
                'description'  => $p->description,
                'created_at' => new \DateTime(),
            ]);
        }
    }
}
