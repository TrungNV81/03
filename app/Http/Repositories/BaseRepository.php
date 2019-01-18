<?php
namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Http\Repositories
 */
class BaseRepository {

    protected $model;

    public function findAll($columns = array(), $conditions = array(), $orderBy = null) {
        if(!empty($columns) && is_array($conditions)) {
            $this->model->select($columns);
        }
        if(!empty($conditions) && is_array($conditions) && !is_null($conditions)) {
            foreach($conditions as $key => $value) {
                $this->model->where($key, $value);
            }
        }

        if(!empty($orderBy) && is_string($orderBy)) {
            $this->model->orderBy($orderBy);
        }

        try {
            if(is_string($columns) && strtolower($columns) === 'count') {
                return $this->model->count();
            } else {
                return $this->model->get();
            }
        } catch(Exception $e) {
            Log::error('ERROR: ' . $e->getMesssage());
            return null;
        }
        
    }

    /**
     * @param array $columns
     * @return bool
     */
    public function insert($columns = array()) {
        $modelInsert = new $this->model;
        try {
            if(!empty($columns) && is_array($columns)) {
                foreach($columns as $column => $value) {
                    $modelInsert->$column = $value;
                }
                return $modelInsert->save();
            }
            return false;
        } catch(Exception $e) {
            Log::error('ERROR: ' . $e->getMesssage());
            return false;
        }
    }
}
?>