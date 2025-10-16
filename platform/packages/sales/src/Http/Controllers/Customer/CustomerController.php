<?php

namespace TCore\Sales\Http\Controllers\Customer;

use App\Enums\Area;
use App\Models\Customer;
use App\Models\RangePrice;
use App\Models\Sector;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Gender;
use TCore\Sales\DataTables\CustomerDataTable;
use TCore\Sales\Http\Requests\CustomerRequest;
use Theme\Cms\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct(
        public Customer $model
    ) {}

    public function index(CustomerDataTable $dataTable)

    {
        // Test query trước
        // try {
        //     $query = Customer::query()->with(['assigns', 'creator'])->get();
        //     dd('Query OK', $query);
        // } catch (\Exception $e) {
        //     dd('Query Error:', $e->getMessage());
        // }
        return $dataTable->render('packages_sales::customers.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Khách hàng'))
        ]);
    }

    public function create()
    {
        return view('packages_sales::customers.create')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Khách hàng'), 'sales.customer.index')->add('Thêm'))

            ->with('gender', Gender::asSelectArray());
    }

    public function store(CustomerRequest $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = auth('admin')->id();

            if (get_auth_admin()->hasManagerShipRoleSales() == false) {
                $data['team_id'] = auth('admin')->user()->team_id;
            }

            $customer = $this->model->create($data);

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $request->whenFilled('assigns', function (array $input) use ($customer) {
                    $customer->assigns()->attach($input);
                });
            }

            DB::commit();

            return utilities()->toRoute('sales.customer.edit', $customer->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('packages_sales::customers.edit')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Khách hàng'), 'sales.customer.index')->add('Sửa'))

            ->with('data', $this->model->findOrFail($id)->load(['province', 'district', 'ward', 'assigns', 'teamSale', 'creator']))

            ->with('gender', Gender::asSelectArray())

            ->with('area', Area::asSelectArray())

            ->with('sectors', Sector::all())

            ->with('range_prices', RangePrice::all())

            ->with('sources', Source::all());
    }

    public function update(CustomerRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            $customer = $this->model->findOrFail($request->input('id'));

            if (isset($data['team_id']) && get_auth_admin()->hasManagerShipRoleSales() == false) {
                unset($data['team_id']);
            }

            $customer->update($data);

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $customer->assigns()->sync($request->input('assigns', []));
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

        return utilities()->toRoute('sales.customer.index');
    }
}
