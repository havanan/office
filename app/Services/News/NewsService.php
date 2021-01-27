<?php

namespace App\Services\News;

use App\Models\NewsCategories;
use App\Repositories\News\NewsCategoryRepository;
use App\Repositories\News\NewsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsService {

  private $_repo;
  private $_tagService;
  private $_categoryService;
  private $_newsCatRepo;

  public function __construct(
      NewsRepository $newsRepository,
      CategoryService $categoryService,
      TagService $tagService,
      NewsCategoryRepository $newsCategoryRepository

  )
  {
    $this->_repo            = $newsRepository;
    $this->_categoryService = $categoryService;
    $this->_tagService      = $tagService;
    $this->_newsCatRepo     = $newsCategoryRepository;
  }

  public function getList($request = false) {

      $params = [
          'search'      => $request->search ?? '',
          'page'        => $request->page ?? CURRENT_PAGE,
          'is_publish'  => $request->is_publish ?? '',
          'categories'  => isset($request->categories) ? json_decode($request->categories) :  []
      ];

      return $this->_repo->getList($params);
  }

  public function delete($newsId){

      DB::beginTransaction();

      try {

          $this->_repo->delete($newsId);
          //xóa liên kết bài viết vs bảng category
          $this->_newsCatRepo->deleteByNewsId($newsId);
          //xóa liên kết bài viết vs bảng tag
          $this->_tagService->deleteRelationTagByNewsId($newsId);
          DB::commit();
      } catch (\Throwable $e) {

          DB::rollback();
      }

      return  $this->getList();
  }

  public function create($request){

      $params = [
          'title'       => $request['title'],
          'image'       => $request['images'],
          'is_publish'      => isset($request['is_publish']) ? (int) $request['is_publish'] : NEWS_PUBLIC,
          'description' => htmlspecialchars($request['description']),
          'content'     => htmlspecialchars($request['content']),
          'slug'        => Str::slug($request['title'], '-'),
          'author_id'   => Auth::id()
        ];
      $tags = $request['tags'];

      $categories = $request['categories'];

      DB::beginTransaction();

      try {

          $news = $this->_repo->create($params);
          //tạo tag
          $tagIds = $this->_tagService->createManyTag($tags);
          //tạo liên kết tag & bài viết
          $this->_tagService->createManyTagNews($tagIds,$news->id);
          //liên kết category
          $this->createInputCategoryNews($categories,$news->id);

          DB::commit();
          return true;
      } catch (\Throwable $e) {
        dd($e);
          DB::rollback();
          return false;
      }



  }
  public function createInputCategoryNews($categories,$newsId){
      $input = [];

      if (empty($categories)){
          return $input;
      }
      foreach ($categories as $category){
          if (isset($category['id']) && $category['id'] != null){
             $item = [
               'news_id'        => $newsId,
               'category_id'    => $category['id'],
                 'created_at'   => Carbon::now()->format('Y-m-d H:i:s')
             ];
             array_push($input,$item);
          }
      }
      //Xóa bản ghi cũ
        $this->_newsCatRepo->deleteByNewsId($newsId);
      //Tạo bản ghi
      if (!empty($input)){

          $this->_newsCatRepo->insertMulti($input);

      }
      return $input;
  }


    public function update($newsId,$request){

        $info = $this->_repo->findById($newsId);

        $params = [
            'title'       => $request['title'],
            'image'       => $request['images'],
            'is_publish'      => isset($request['is_publish']) ? (int) $request['is_publish'] : NEWS_PUBLIC,
            'description' => htmlspecialchars($request['description']),
            'content'     => htmlspecialchars($request['content']),
            'slug'        => Str::slug($request['title'], '-')
          ];

        $tags = $request['tags'];

        $categories = $request['categories'];

        DB::beginTransaction();

        try {

            $this->_repo->updateById($newsId,$params);
            //tạo tag
            $tagIds = $this->_tagService->createManyTag($tags);
            //tạo liên kết tag & bài viết
            $this->_tagService->createManyTagNews($tagIds,$newsId);
            //liên kết category
            $this->createInputCategoryNews($categories,$newsId);

            DB::commit();
            return true;
        } catch (\Throwable $e) {

            DB::rollback();
            return false;
        }
    }

    public function findById($newsId){

        return $this->_repo->findById($newsId);

    }
}

