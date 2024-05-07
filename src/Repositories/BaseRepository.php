<?php

namespace Nisimpo\Requisition\Repositories;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository
{
    protected Model $model;

    protected Application $app;

    /**
     * @param Application $app
     *
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable(): array;

    /**
     * Get joinable fields array
     *
     * @return array
     */
    abstract public function getTablesJoinable(): array;

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model(): string;

    /**
     * Make Model instance
     *
     * @throws Exception
     *
     * @return Model
     */
    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array|null $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array|null $joins
     * @return Builder
     */
    public function allQuery(array $search = null, int $skip = null, int $limit = null, array $joins = null): Builder
    {
        $query = $this->model->newQuery();

        if (!is_null($search))
        {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if(!is_null($joins))
        {
            foreach ($joins as $key => $value){
                if(in_array($key,$this->getTablesJoinable())){
                    $query->join($key,$value[0],$value[1],$value[2]);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     * @param array $joins
     * @return Collection|array
     */
    public function all(array $search = [], int $skip = null, int $limit = null, array $columns = ['*'], $joins = []): Collection|array
    {
        $query = $this->allQuery($search, $skip, $limit, $joins);
        return $query->get($columns);
    }

    /**
     * instantiate new model instance with or without inputs
     * @param array $input user inputs
     * @return Model
     */
    public function newModelInstance(array $input = []): Model
    {
        return $this->model->newInstance($input);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create(array $input): Model
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Create new model record with related model
     *
     * @param array $input user inputs
     * @param Model $parentModel parent related model
     * @param string $relationship child relationship name from relate model instance
     * @return Model new model instance tobe created
     */
    public function createWithRelation(array $input, Model $parentModel, string $relationship): Model
    {
        $model = $this->model->newInstance($input);

        return $parentModel->{$relationship}()->save($model);
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return Model|Builder|null
     */
    public function find(int $id, array $columns = ['*']): Model|Builder|null
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return Model|Builder
     */
    public function update(array $input, int $id): Model|Builder
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     *@throws Exception
     *
     */
    public function delete(int $id): mixed
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }
}
