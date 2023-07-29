<?php

namespace App\Services\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class Service
{
    public function store($data)
    {
        try {
            DB::beginTransaction();
            $tags = $data['tags'];
            $category = $data['category'];
            unset($data['tags'], $data['category']);

            $data['category_id'] = $this->getCategoryId($category);
            $tagIds = $this->getTagIds($tags);


            $post = Post::create($data);
            $post->tags()->attach($tagIds);

            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return $post;
    }

    public function update($post, $data)
    {
        try {
            DB::beginTransaction();

            $tags = $data['tags'];
            $category = $data['category'];
            unset($data['tags'], $data['category']);

            $data['category_id'] = $this->getCategoryIdWithUpdate($category);
            $tagIds = $this->getTagIdsWithUpdate($tags);

            $post->update($data);
            $post->tags()->sync($tagIds);


            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return $post->fresh();

    }

    private function getCategoryIdWithUpdate($category)
    {
        if (!isset($category['id'])) {
            return Category::create($category)->id;
        }

        Category::find($category['id'])->update($category);

        return $category['id'];
    }

    private function getCategoryId($category)
    {
        return !isset($category['id']) ? Category::create($category)->id : $category['id'];
    }

    private function getTagIds($tags)
    {
        $tagIds = [];

        foreach ($tags as $tag) {
            $tag = !isset($tag['id']) ? Tag::create($tag) : Tag::find($tag['id']);
            $tagIds[] = $tag->id;
        }

        return $tagIds;

    }

    private function getTagIdsWithUpdate($tags)
    {
        $tagIds = [];

        foreach ($tags as $tag) {
            if (!isset($tag['id'])) {
                $tag = Tag::create($tag);
            } else {
                $currentTag = Tag::find($tag['id']);
                $currentTag->update($tag);
                $tag = $currentTag->fresh();
            }
            $tagIds[] = $tag->id;
        }
        return $tagIds;

    }



}
