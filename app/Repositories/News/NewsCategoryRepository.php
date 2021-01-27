<?php

namespace App\Repositories\News;

use App\Models\News;
use App\Models\NewsCategories;
use App\Models\NewsTags;
use App\Repositories\Base\BaseRepository;

class NewsCategoryRepository extends BaseRepository {

    public function __construct(NewsCategories $model) {

        $this->_model = $model;
    }

    public function deleteByNewsId($newsId){
        return $this->_model->where('news_id',$newsId)->delete();
    }

}
