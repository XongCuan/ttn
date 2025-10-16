<?php

namespace TCore\Sales\Http\Controllers\Enq;

use App\Enums\Area;
use App\Models\Enq;
use App\Models\RangePrice;
use App\Models\Sector;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Gender;
use TCore\Sales\DataTables\EnqDataTable;
use TCore\Sales\Http\Requests\EnqRequest;
use Theme\Cms\Http\Controllers\Controller;

class EnqController extends Controller
{
    public function __construct(
        public Enq $model
    ) {}

    public function index(EnqDataTable $dataTable)

    {
        // Test query trước
        // try {
        //     $query = Enq::query()->with(['assigns', 'creator'])->get();
        //     dd('Query OK', $query);
        // } catch (\Exception $e) {
        //     dd('Query Error:', $e->getMessage());
        // }
        return $dataTable->render('packages_sales::enqs.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Yêu Cầu Báo giá'))
        ]);
    }

    public function create()
    {
        return view('packages_sales::enqs.create')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Yêu Cầu Báo Giá'), 'sales.enq.index')->add('Thêm'))

            ->with('gender', Gender::asSelectArray());
    }

    public function store(EnqRequest $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = auth('admin')->id();

            if (get_auth_admin()->hasManagerShipRoleSales() == false) {
                $data['team_id'] = auth('admin')->user()->team_id;
            }

            $Enq = $this->model->create($data);

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $request->whenFilled('assigns', function (array $input) use ($Enq) {
                    $Enq->assigns()->attach($input);
                });
            }

            DB::commit();

            return utilities()->toRoute('sales.enq.edit', $Enq->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('packages_sales::Enqs.edit')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Khách hàng'), 'sales.enq.index')->add('Sửa'))

            ->with('data', $this->model->findOrFail($id)->load(['province', 'district', 'ward', 'assigns', 'teamSale', 'creator']))

            ->with('gender', Gender::asSelectArray())

            ->with('area', Area::asSelectArray())

            ->with('sectors', Sector::all())

            ->with('range_prices', RangePrice::all())

            ->with('sources', Source::all());
    }

    public function update(EnqRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            $Enq = $this->model->findOrFail($request->input('id'));

            if (isset($data['team_id']) && get_auth_admin()->hasManagerShipRoleSales() == false) {
                unset($data['team_id']);
            }

            $Enq->update($data);

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $Enq->assigns()->sync($request->input('assigns', []));
            }

            DB::commit();

            return utilities()->responseBack();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id, Request $request)
    {
        if (get_auth_admin()->hasLeaderShipRoleSales()) {
            abort(403);
        }

        $this->model->findOrFail($id)->delete();

        if ($request->ajax()) {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('sales.enq.index');
    }
}
