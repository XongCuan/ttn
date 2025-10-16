<?php

namespace TCore\Accounting\Http\Controllers\Receipt;

use App\Models\Receipt;
use App\Models\ReceiptType;
use Illuminate\Support\Facades\DB;
use TCore\Accounting\DataTables\Receipt\ReceiptDataTable;
use TCore\Accounting\Http\Requests\Receipt\ReceiptRequest;
use TCore\Base\Services\File\FileUploadService;
use Theme\Cms\Http\Controllers\Controller;

class ReceiptController extends Controller
{
    public function __construct(
        public Receipt $model,
        public FileUploadService $fileUploadService
    )
    {
        
    }

    public function index(ReceiptDataTable $dataTable)
    {
        return $dataTable->render('packages_accounting::receipts.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Danh sách'))
        ]);
    }

    public function create()
    {
        return view('packages_accounting::receipts.modal.create')
        
        ->with('types', ReceiptType::all());
    }

    public function store(ReceiptRequest $res)
    {
        DB::beginTransaction();

        try {
            
            $data = $res->validated();

            $data['amount'] = string_to_integer($data['amount']);

            if(isset($data['attachments']) && $data['attachments'])
            {
                $data['attachments'] = $this->fileUploadService->setFolder('receipts')->uploadMultipleFilepondEncode($data['attachments'])->getInstance();
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
        return view('packages_accounting::receipts.modal.show')

        ->with('data', $this->model->findOrFail($id)->load('type'));
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}