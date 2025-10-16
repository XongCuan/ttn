<?php

namespace TCore\Superadmin\Http\Controllers\Document;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\DB;
use TCore\Superadmin\DataTables\Document\DocumentDataTable;
use TCore\Superadmin\Http\Requests\Document\DocumentRequest;
use TCore\Base\Services\File\FileUploadService;
use Theme\Cms\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function __construct(
        public Document $model,
        public FileUploadService $fileUploadService
    )
    {
        
    }

    public function index(DocumentDataTable $dataTable)
    {
        return $dataTable->render('packages_superadmin::documents.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Danh sách'))
        ]);
    }

    public function create()
    {
        return view('packages_superadmin::documents.modal.create')
        
        ->with('types', DocumentType::getFlatTree());
    }

    public function store(DocumentRequest $res)
    {
        DB::beginTransaction();

        try {
            
            $data = $res->validated();

            if(isset($data['attachments']) && $data['attachments'])
            {
                $data['attachments'] = $this->fileUploadService->setFolder('documents')->uploadMultipleFilepondEncode($data['attachments'])->getInstance();
            }

            $this->model->create($data);

            DB::commit();

            return utilities()->responseAjax();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        return view('packages_superadmin::documents.modal.show')

        ->with('data', $this->model->findOrFail($id)->load('type'));
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}