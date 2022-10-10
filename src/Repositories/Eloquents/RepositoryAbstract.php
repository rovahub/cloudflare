<?php

namespace Rovahub\Cloudflare\Repositories\Eloquents;

use Rovahub\Cloudflare\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected $model;
    protected $originalModel;

    public function __construct()
    {
        $this->setModel();
    }

    public function resetModel()
    {
        $this->model = new $this->originalModel;
        return $this;
    }

    public function getPrimaryKey()
    {
        return $this->model->getKeyName();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
        $this->originalModel = $this->model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function createOrUpdate($data, $condition = [])
    {
        if (is_array($data)) {
            if (empty($condition)) {
                $item = new $this->model;
            } else {
                $item = $this->getByFirst($condition);
            }
            if (empty($item)) {
                $item = new $this->model;
            }
            $item = $item->fill($data);
        } elseif ($data instanceof Model) {
            $item = $data;
        } else {
            return false;
        }
        if ($item->save()) {
            return $item;
        }
        $this->resetModel();
        return false;
    }

    public function count($condition = []): int
    {
        if (empty($condition)) {
            return $this->model->count();
        }
        return $this->model->where($condition)->count();
    }

    public function pagination($page = 20, $condition = [], $orderById = 'desc'): LengthAwarePaginator
    {
        if (empty($condition)) {
            return $this->model->orderBy($this->getPrimaryKey(), $orderById)->paginate($page);
        }
        return $this->model->orderBy($this->getPrimaryKey(), $orderById)->where($condition)->paginate($page);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getByFirst(array $condition = [], array $select = ['*'])
    {
        if (!empty($select)) {
            $data = $this->model->where($condition)->select($select);
        } else {
            $data = $this->model->where($condition);
        }
        return $data->first();
    }

    public function updateById($id, array $data): int
    {
        return $this->model->where($this->getPrimaryKey(), $id)->update($data);
    }

    public function deleteById($id): int
    {
        return $this->model->destroy($id);
    }

    public function delete($ids = [])
    {
        return $this->model->whereIn($this->getPrimaryKey(), $ids)->delete();
    }
}
