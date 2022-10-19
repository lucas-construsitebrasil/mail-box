<?php

namespace App\Business;


trait Business
{

    protected $repository;
    protected $repositoryClass;

    public function __construct()
    {
        $this->repositoryClass = '\App\Models\\' . str_replace('App\Business\\', '', get_class($this));
        if (class_exists($this->repositoryClass)) {
            $this->repository = new $this->repositoryClass();
        } else {
            $this->repositoryClass = rtrim($this->repositoryClass, 's');
            if (class_exists($this->repositoryClass)) {
                $this->repository = new $this->repositoryClass();
            } 
        }
    }
}
