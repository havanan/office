<?php
namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\_model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** @var _model $_model */
    protected $_model;

    public function create($attribute)
    {
        return $this->_model->create($attribute);
    }

    public function find($id, $relations = [])
    {
        if (!empty($relations)) {
            return $this->_model->with($relations)->find($id);
        }
        return $this->_model->find($id);
    }

    public function delete($id)
    {
        return $this->_model->where('id', $id)->delete();
    }

    public function updateById($id, $input)
    {
        return $this->_model->where('id', $id)
            ->update($input);
    }

    public function firstOrNew($input)
    {
        return $this->_model->firstOrNew($input);
    }

    public function firstOrCreate($input)
    {
        return $this->_model->firstOrCreate($input);
    }

    public function insertMulti($input)
    {
        return $this->_model->insert($input);
    }

    public function createGetID($attribute)
    {
        $attribute['created_at'] = date('Y-m-d H:i:s');
        return $this->_model->insertGetId($attribute);
    }

    public function all() {
        return $this->_model->get();
    }
}
