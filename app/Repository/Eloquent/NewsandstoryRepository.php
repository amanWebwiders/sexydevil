<?php

namespace App\Repository\Eloquent;



use App\Models\NewsAndStory;
use App\Models\{Comment, Like};


use Illuminate\Contracts\Cache\Repository as Cache;

use Illuminate\Support\Facades\Log;

use DB;



class NewsandstoryRepository

{



    protected $model;

    protected $cache;

    protected $Commentmodel, $Likemodel;

    protected $NotificationModel;



    public function __construct(

        NewsAndStory $model,
        Comment $Commentmodel,
        Like $Likemodel,

    ) {

        $this->model = $model;
        $this->Commentmodel = $Commentmodel;
        $this->Likemodel = $Likemodel;
    }



    //its a create function used insert data 



    public function create($allData)

    {

        try {

            return $this->model->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.create(): " . $e->getMessage());

            throw $e;

            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);

        }
    }
    public function createComment($allData)

    {

        try {

            return $this->Commentmodel->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.createComment(): " . $e->getMessage());

            throw $e;

            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);

        }
    }

    public function createLike($allData)

    {

        try {

            return $this->Likemodel->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.createLike(): " . $e->getMessage());

            throw $e;

            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);

        }
    }



    public function update($byWhere, $update)

    {

        try {

            return $this->model->where($byWhere)->update($update);
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.create(): " . $e->getMessage());

            throw $e;

            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);

        }
    }
    public function getOneLike($byWhere)

    {

        try {

            $data = $this->Likemodel->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.getOneLike(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }


    public function getOne($byWhere)

    {

        try {

            $data = $this->model->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.getUser(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
  public function getOneComment($byWhere)

    {

        try {

            $data = $this->Commentmodel->with('likes')->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.getOneComment(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }




    public function getAll()

    {

        try {

            return $this->model->with('user')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.userList(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

 public function deleteLike($byWhere)

    {

        try {

            if (empty($byWhere)) {

                return 0;
            }
            return $this->Likemodel->where($byWhere)->delete();
        } catch (\Exception $e) {

            Log::error("Error in NewsandstoryRepository.deleteData(): " . $e->getMessage());

            throw $e;

            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);

        }
    }

    public function delete(array $byWhere) {
        try { 
            return $this->model->where($byWhere)->delete();
        } catch (\Exception $e) {
            Log::error("Error in NewsandstoryRepository.deleteData(): " . $e->getMessage());
            return false;
        }
    }





   public function getByWhere($byWhere, $orderBy = ['id' => 'asc'])
{
    try {
        $query = $this->model->with('user', 'likes', 'comments.user')->where(function ($query) use ($byWhere) {
            foreach ($byWhere as $column => $condition) {
                if (is_array($condition)) {
                    if ($condition[0] === "IN") {
                        unset($condition[0]);
                        $query->whereIn($column, $condition);
                    } else {
                        $query->where($column, $condition[0], $condition[1]);
                    }
                } else {
                    $query->where($column, $condition);
                }
            }
        });

        // Handle special case for ['RAND()'] to randomize order
        if (isset($orderBy[0]) && strtoupper($orderBy[0]) === 'RAND()') {
            $query->inRandomOrder();
        } else {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        return $query->get();
    } catch (\Exception $e) {
        Log::error("Error in NewsandstoryRepository.getByWhere(): " . $e->getMessage());
        return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
    }
}

public function getUserStoriesWhere (array $where, $valid_post = true) {
    try {
        $query = $this->model->with('user', 'likes', 'comments.user')->where($where);
        if($valid_post) {
            $query->where(function ($query) {
                $query->whereNull('validity')
                      ->orWhere('validity', '>=', now());
            });
        }
        return $query->orderBy('id', 'desc');
    } catch (\Exception $exception) {
        Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
    }
}

}
