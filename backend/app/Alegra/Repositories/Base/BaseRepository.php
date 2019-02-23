<?php

namespace Alegra\Repositories\Base;

abstract class BaseRepository {

    const PAGINATE = true;

    public $filters = [];

    abstract public function getModel();

    public function paginate($count) {
        return $this->getModel()->orderBy($this->getModel()->primaryKey, 'desc')->paginate($count);
    }

    public function findOrFail($id) {
        return $this->getModel()->findOrFail($id);
    }

    public function where($key, $value, $ope = '=') {
        return $this->getModel()->where($key, $ope, $value);
    }

    public function create(array $data) {
        return $this->getModel()->create($data);
    }

    public function insert(array $data) {
        return $this->getModel()->insert($data);
    }

    public function update($entity, array $data) {
        if (is_numeric($entity)) {
            $entity = $this->findOrFail($entity);
        }
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    public function delete($entity) {
        if (is_numeric($entity)) {
            $entity = $this->findOrFail($entity);
        }
        $entity->delete();
        return $entity;
    }

    public function get() {
        return $this->getModel()->get();
    }

    public function all() {
        return $this->getModel()->all();
    }

}

?>