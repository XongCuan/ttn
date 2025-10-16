<?php

namespace TCore\Outsource\Repositories\Project;

use App\Models\Project;
use TCore\Support\Repositories\Eloquent\RepositoryAbstract;

class ProjectRepository extends RepositoryAbstract implements ProjectRepositoryInterface
{
    public function getModel()
    {
        return Project::class;
    }
}