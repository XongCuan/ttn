<?php

namespace TCore\Sales\Http\Controllers\Enq;

use App\Enums\Area;
use App\Models\Enq;
use App\Models\Customer;
use App\Models\EnqDetail;
use App\Models\RangePrice;
use App\Models\Sector;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Gender;
use TCore\Base\Enums\Status;
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

        return $dataTable->render('packages_sales::enqs.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Yêu Cầu Báo giá'))
        ]);
    }

    public function create()
    {
        $customers = Customer::select('id', 'fullname', 'company')->get();
        return view('packages_sales::enqs.create')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Yêu Cầu Báo Giá'), 'sales.enq.index')->add('Thêm'))
            ->with('customers', $customers)
            ->with('gender', Gender::asSelectArray())
            ->with('status', Status::asSelectArray());
    }

    public function store(EnqRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = auth('admin')->id();
            $data['status'] = $data['status'] ?? 'Pending';

            if (get_auth_admin()->hasManagerShipRoleSales() == false) {
                $data['team_id'] = auth('admin')->user()->team_id;
            }

            // ✅ Tự động sinh mã ENQ
            $data['enq_code'] = Enq::generateEnqCode();

            // Tự động lấy thông tin từ customer nếu có
            if (!empty($data['customer_id'])) {
                $customer = Customer::find($data['customer_id']);
                if ($customer) {
                    $data['fullname'] = $data['fullname'] ?? $customer->fullname;
                    $data['company'] = $data['company'] ?? $customer->company;
                    $data['phone'] = $data['phone'] ?? $customer->phone;
                    $data['email'] = $data['email'] ?? $customer->email;
                }
            }

            $enq = $this->model->create($data);
            // dd($enq);

            if ($request->filled('details')) {
                $details = json_decode($request->input('details'), true);

                foreach ($details as $item) {
                    EnqDetail::create([
                        'enq_id' => $enq->id,
                        'code' => $item['code'] ?? null,
                        'description_sale' => $item['description_sale'] ?? null,
                        'quantity' => $item['quantity'] ?? 1,
                        'unit' => $item['unit'] ?? null,
                        'note' => $item['note'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ]);
                }
            }
            // dd($request);
            // dd($enq);

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $request->whenFilled('assigns', function (array $input) use ($enq) {
                    $enq->assigns()->attach($input);
                });
            }

            DB::commit();

            return utilities()->toRoute('sales.enq.edit', $enq->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {

        return view('packages_sales::enqs.edit')
            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Yêu Cầu Báo Giá'), 'sales.enq.index')->add('Sửa')) // ✅ Sửa label
            ->with('data', $this->model->findOrFail($id)->load(['province', 'district', 'ward', 'assigns', 'teamSale', 'creator']))
            ->with('gender', Gender::asSelectArray())

            ->with('status', Status::asSelectArray());
    }

    public function update(EnqRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $enq = $this->model->findOrFail($request->input('id'));

            if (isset($data['team_id']) && get_auth_admin()->hasManagerShipRoleSales() == false) {
                unset($data['team_id']);
            }

            $enq->update($data);

            // ✅ Cập nhật chi tiết với giá và thời gian hàng
            if ($request->filled('details')) {
                $details = json_decode($request->input('details'), true);

                $enq->details()->delete();

                foreach ($details as $item) {
                    $enq->details()->create([
                        'code' => $item['code'] ?? null,
                        'description_sale' => $item['description_sale'] ?? null,
                        'quantity' => $item['quantity'] ?? 1,
                        'unit' => $item['unit'] ?? null,
                        'unit_price' => $item['unit_price'] ?? null,        // ✅ Thêm
                        'total_price' => $item['total_price'] ?? null,      // ✅ Thêm
                        'delivery_time' => $item['delivery_time'] ?? null,  // ✅ Thêm
                        'note' => $item['note'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ]);
                }
            }

            if (get_auth_admin()->hasLeaderShipRoleSales()) {
                $enq->assigns()->sync($request->input('assigns', []));
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
        if (!get_auth_admin()->hasLeaderShipRoleSales()) {
            abort(403);
        }

        $this->model->findOrFail($id)->delete();

        if ($request->ajax()) {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('sales.enq.index');
    }
}
