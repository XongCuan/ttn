<?php

namespace TCore\Support\Breadcrumb;

class SimpleBreadcrumb
{
        /**
     * Mảng chứa breadcrumbs
     *
     * @var array
     */
    public array $breadcrumbs = [];

    public $guard;

    public function getBreadcrumbs(): array{
        return $this->breadcrumbs;
    }

    public function add(string $label, string $url = ''): self
    {
        $this->breadcrumbs[] = [
            'label' => $label,
            'url' => $url
        ];
        return $this;
    }

    public function guard($guard = 'admin'): self
    {
        $this->guard = $guard;
        return $this;
    }

    public function addByRouteName(string $label, string $route_name = ''): self
    {
        $this->breadcrumbs[] = [
            'label' => $label,
            'url' => $route_name != '' ? route($route_name) : ''
        ];
        return $this;
    }

    public function addByUrl(string $label, string $url = ''): self
    {
        $this->breadcrumbs[] = [
            'label' => $label,
            'url' => $url
        ];
        return $this;
    }
}