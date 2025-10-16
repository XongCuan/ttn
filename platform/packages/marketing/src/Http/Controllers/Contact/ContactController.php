<?php

namespace TCore\Marketing\Http\Controllers\Contact;

use App\Enums\Area;
use App\Enums\Contact\ContactStatus;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\RangePrice;
use App\Models\Sector;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\Gender;
use TCore\Marketing\DataTables\ContactDataTable;
use TCore\Marketing\Http\Requests\ContactRequest;
use Theme\Cms\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct(
        public Contact $model
    )
    {
        
    }

    public function index(ContactDataTable $dataTables)
    {
        return $dataTables->render('packages_marketing::contacts.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Liên hệ'))
        ]);
    }

    public function create()
    {
        return view('packages_marketing::contacts.create')

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Liên hệ'), 'marketing.contact.index')->add('Thêm'))

        ->with('gender', Gender::asSelectArray())

        ->with('status', ContactStatus::asSelectArrayAvailable())
        
        ->with('area', Area::asSelectArray())

        ->with('types', ContactType::all())

        ->with('sectors', Sector::all())
        
        ->with('range_prices', RangePrice::all())

        ->with('sources', Source::all());
    }

    public function store(ContactRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = auth('admin')->id();
            $data['department'] = Department::Marketing;

            if(get_auth_admin()->hasManagerShipRoleMkt() == false)
            {
                $data['team_id'] = auth('admin')->user()->team_id;
            }
            
            $contact = $this->model->create($data);

            if(get_auth_admin()->hasLeaderShipRoleMkt())
            {
                $request->whenFilled('assigns', function (array $input) use ($contact) {
                    $contact->assigns()->attach($input);
                });
            }

            DB::commit();

            return utilities()->toRoute('marketing.contact.edit', $contact->id);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('packages_marketing::contacts.edit')

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Liên hệ'), 'marketing.contact.index')->add('Sửa'))

        ->with('data', $this->model->findOrFail($id)->load(['province', 'district', 'ward', 'assigns', 'teamMkt']))

        ->with('gender', Gender::asSelectArray())

        ->with('status', ContactStatus::asSelectArray())
        
        ->with('area', Area::asSelectArray())

        ->with('types', ContactType::all())

        ->with('sectors', Sector::all())
        
        ->with('range_prices', RangePrice::all())

        ->with('sources', Source::all());
    }

    public function update(ContactRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            $contact = $this->model->findOrFail($request->input('id'));

            if(isset($data['team_id']) && get_auth_admin()->hasManagerShipRoleMkt() == false)
            {
                unset($data['team_id']);
            }

            $contact->update($data);

            if(get_auth_admin()->hasLeaderShipRoleMkt())
            {
                $contact->assigns()->sync($request->input('assigns', []));
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
        if(get_auth_admin()->hasLeaderShipRoleMkt())
        {
            abort(403);
        }

        $this->model->findOrFail($id)->delete();

        if($request->ajax())
        {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('marketing.contact.index');
    }
}