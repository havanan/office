<?php

namespace App\Services\News;

use App\Repositories\News\NewsCategoryRepository;
use App\Repositories\News\NewsTagRepository;
use App\Repositories\News\TagRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TagService {
  private  $_repo;
  private  $_newsTagRepo;

  public function __construct(
        TagRepository $tagRepository,
        NewsTagRepository $newsTagRepository
  )
  {
    $this->_repo        = $tagRepository;
    $this->_newsTagRepo = $newsTagRepository;
  }

  public function getList($request = false) {

      $search = $request->search ?? '';
      $page   = $request->page ?? CURRENT_PAGE;

      $params = [
          'search' => $search,
          'page'   => $page
      ];

      return $this->_repo->getList($params);
  }
    public function findTag($request = false) {

        $search = $request->search ?? '';

        $params = [
            'search' => $search,
            'page'   => 1
        ];

        return $this->_repo->findTag($params);
    }
  public function delete($tagId){

      $this->_repo->delete($tagId);

      return  $this->getList();
  }

  public function create($params){

      $this->_repo->create($params);

      return $this->getList();

  }

    public function update($tagId,$params){
        $this->_repo->updateById($tagId,$params);

        return $this->getList();
    }

    public function createManyTag($tags){
      $ids = [];

      if (empty($tags)){

          return $ids;

      }
        foreach ($tags as $name){

            $id = $name['key'];

            if ($id == null && $name['value'] != null){

                $input = [
                    'name' => $name['value'],
                    'slug' => Str::slug($name['value'], '-')
                ];

                $tag = $this->_repo->create($input);

                $id = $tag->id;

            }

            array_push($ids,$id);
        }
        return $ids;
    }

    public function createManyTagNews($tagIds,$newsId){
      $input = [];
      if (!empty($tagIds)){
          foreach ($tagIds as $id){
                $item = [
                    'tag_id'     => $id,
                    'news_id'    => $newsId,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
                array_push($input,$item);
          }
      }

      if (!empty($input)){
        //Xóa bản ghi cũ
        $this->deleteRelationTagByNewsId($newsId);  
        //Tạo bản ghi mới
          $this->_newsTagRepo->insertMulti($input);
      }
    }
    public function deleteRelationTagByNewsId($newsId){

        return $this->_newsTagRepo->deleteByNewsId($newsId);

    }
}

