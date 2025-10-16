<?php

namespace TCore\Setting\Http\Controllers;

use App\Enums\Setting\SettingGroup;
use App\Models\Setting;
use Illuminate\Http\Request;
use Theme\Cms\Http\Controllers\Controller as CmsController;

class  Controller extends CmsController
{
    public function __construct(
        public Setting $model
    )
    {
        
    }
    
    public function index($group = null, $url_update)
    {
        $filter = [];

        $current = trans('Chung');

        if($group && $group = SettingGroup::tryFrom($group))
        {
            $filter['group'] = $group;

            $current = $group->description();
        }

        $settings = $this->model->getBy(filter: $filter, sort: ['id', 'asc']);
        
        $breadcrumbs = $this->breadcrumbs()->add(trans('Cài đặt'))->add($current);

        return view('packages_setting::index', compact('settings', 'breadcrumbs', 'url_update'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'submitter');

        $this->model->updateMultipleRecord($data);
        
        return utilities()->responseBack();
    }
}