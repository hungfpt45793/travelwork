<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Diendan_input extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'diendan_input';

    protected $primaryKey = 'input_id';

    protected $fillable = [
        'input_id',
        'type_input_slug',
        'content',
        'post_id',
        'cate_id',
        'deleted_at',
        'updated_at'
    ];

    public static function getPostMeta($slug, $postId) {
        try {
            $inputModel = new Diendan_input();

            $inputOld = $inputModel->where([
                'post_id' => $postId,
                'type_input_slug' => $slug
            ])->first();

            if (empty($inputOld)) {
                return '';
            }

            return $inputOld->content;
        } catch (\Exception $e) {
            Log::error('Entity->Input->getPostMeta: Lỗi lấy nội dung input');

            return null;
        }

    }

    public static function getPostMetaCate($slug, $cateId) {
        try {
            $inputModel = new Diendan_input();

            $inputOld = $inputModel->where([
                'cate_id' => $cateId,
                'type_input_slug' => $slug
            ])

                ->first();

            if (empty($inputOld)) {
                return '';
            }

            return $inputOld->content;
        } catch (\Exception $e) {
            Log::error('Entity->Input->getPostMeta: Lỗi lấy nội dung input');

            return null;
        }

    }

    public function updateInput($typeInputDatabase, $request, $postId, $typePost='post') {
        try {
            $this->where([
                'post_id' =>  $postId
            ])
                ->delete();

            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
                    $contentInput =  $request->input($typeInput->slug);


//                    if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'list'), true) && strpos($typeInput->type_input, 'listMultil') >= 0) {
//                        $contentInput = ( !empty($contentInput) && count($contentInput) >= 1) ? implode(',', $contentInput) : $contentInput;
//                    }
                    $this->insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => $contentInput,
                        'post_id' => $postId,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Entity->Input->updateInput: Lỗi cập nhật input');
        }
    }

    public static function showTitle($postId) {
        try {
            $inputModel = new Diendan_input();

            $input = $inputModel->where('post_id', $postId)
                ->first();

            return $input->content;
        } catch(\Exception $e) {
            Log::error('Entity->Input->showTitle: Lỗi hiển thị title input');

            return null;
        }

    }

    public static function saveInput($typeInputSlug, $postId, $content) {
        try {
            $inputModel = new Diendan_input();

            $input = $inputModel->where([
                'post_id' =>  $postId
            ])->where('type_input_slug', $typeInputSlug)
                ->first();

            if (!empty($input)) {
                Diendan_input::where([
                    'post_id' =>  $postId
                ])->where('type_input_slug', $typeInputSlug)
                    ->update([
                        'content' => $content,
                    ]);

                return true;
            }

            Diendan_input::insert([
                'type_input_slug' => $typeInputSlug,
                'content' => $content,
                'post_id' => $postId,
            ]);
        } catch (\Exception $e) {
            Log::error('Entity->Input->saveInput: Lỗi cập nhật Input');

            return null;
        }
    }
}
