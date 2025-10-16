<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use TCore\Base\Models\BaseModel;

class Document extends BaseModel
{
    protected $table = 'documents';

    protected $fillable = [
        'type_id', 'document_date', 'attachments', 'desc'
    ];

    protected function casts()
    {
        return [
            'attachments' => AsArrayObject::class
        ];
    }

    public function type()
    {
        return $this->belongsTo(DocumentType::class, 'type_id')->withDefault();
    }
}
