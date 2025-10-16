<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use TCore\Base\Models\BaseModel;

class DocumentType extends BaseModel
{
    use NodeTrait;
    protected $table = 'document_types';

    protected $fillable = [
        'name', 'desc', '_lft', '_rgt', 'parent_id'
    ];

    public static function getToTree(array $filter = [], array $relations = [], $sort = ['id', 'ASC'])
    {
        $query = self::applyFilters($filter);
        $query = $query->orderBy(...$sort);
        $instance = $query->withDepth()
            ->get()
            ->toTree();

        return $instance;
    }

    public static function getFlatTree(array $filter = [], array $relations = [], $sort = ['id', 'ASC'])
    {
        $query = self::applyFilters($filter);
        $query = $query->orderBy(...$sort);
        $instance = $query->withDepth()
            ->get()
            ->toFlatTree();

        return $instance;
    }
}
