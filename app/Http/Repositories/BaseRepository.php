<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(protected Model $model) {}

    public function findAll(array $relations = [])
    {
        return $this->model::with($relations)->get();
    }

    public function findAllFiltered(array $filters = [], array $relations = [])
    {
        return $this->model::with($relations)->filters($filters)->get();
    }

    public function findById(string $id, array $relations = [])
    {
        return $this->model::with($relations)->findOrFail($id);
    }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function update(string $id, $data)
    {
        $model = $this->model::find($id);
        $model->update($data);
        $model->refresh();
        return $model;
    }

    public function delete(string $id)
    {
        $model = $this->model::find($id);
        $model->delete();
        return $model;
    }

    public function insert(array $data)
    {
        return $this->model::insert($data);
    }
}
