<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository
{
    /**
     *  新增相片
     * 
     *  @param array $input
     * 
     *  @return mixed
     */
    public function store(array $input)
    {
        return Photo::create($input);
    }
    /**
     *  取得單一相片
     * 
     *  @param string $imageable_type
     *  @param int $imageable_id
     * 
     *  @return \App\Models\Photo|null
     */
    public function get_single_photo(string $imageable_type, int $imageable_id)
    {
        return Photo::where('imageable_type', $imageable_type)->where('imageable_id', $imageable_id)->first();
    }
}