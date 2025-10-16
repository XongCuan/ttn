<?php

namespace Theme\Cms\Sidebar;

use App\Models\Admin;

class SidebarData
{
    public $menu;

    public $admin;

    public function isHeader(array $item_menu)
    {
        return isset($item_menu['is_header']) && $item_menu['is_header'] == true;
    }

    public function hasSub(array $item_menu)
    {
        return isset($item_menu['sub']) && count($item_menu['sub']) > 0;
    }

    public function getUrl(array $item_menu): string
    {
        if(isset($item_menu['route_name']) && $item_menu['route_name'])
        {
            return route($item_menu['route_name'], $item_menu['params'] ?? []);
        }
        
        return '#';
    }

    public function visiable(array $item_menu)
    {
        if($this->getAdmin()->isSuperadmin())
        {
            return true;
        }
        
        if(isset($item_menu['visiable']['is_superadmin']) && $item_menu['visiable']['is_superadmin'])
        {
            return $this->getAdmin()->isSuperadmin();
        }

        

        if(isset($item_menu['visiable']['department']) 
            && $item_menu['visiable']['department']
        )
        {
            $department = $item_menu['visiable']['department'];
            
            if($this->getAdmin()->isSuperDepartment($department->super()))
            {
                return true;
            }

            if($this->getAdmin()->isDepartment($department))
            {
                if(isset($item_menu['visiable']['is_manager']) 
                    && $item_menu['visiable']['is_manager'] == true
                )
                {
                    return $this->getAdmin()->isManager($department);
                }

                if(isset($item_menu['visiable']['is_leader']) 
                    && $item_menu['visiable']['is_leader'] == true
                )
                {
                    return $this->getAdmin()->isLeader($department);
                }
                return true;
            }
            
            return false;
        }else {
            if(isset($item_menu['visiable']['is_manager']) 
                && $item_menu['visiable']['is_manager'] == true
            )
            {
                return $this->getAdmin()->isRoleManager() || $this->getAdmin()->isRoleSuperManager();
            }

            if(isset($item_menu['visiable']['is_leader']) 
                && $item_menu['visiable']['is_leader'] == true
            )
            {
                return $this->getAdmin()->isRoleLeader();
            }
        }

        return true;
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function getMenu(): array
    {
        return $this->menu;
    }

    public function setData(): self
    {
        $this->menu = config('themes_cms.sidebar_left', []);

        $this->admin = get_auth_admin()->loadMissing(['team', 'managerDepartments']);

        return $this;
    }

    public static function make(): self
    {
        return new static;
    }
}