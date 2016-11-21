<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Someline\Http\Requests;
use Someline\Http\Controllers\BaseController;
use GeniusTS\Roles\Models\Role;


class RoleController extends BaseController
{
    private $role;

    function __construct()
    {

    }

    /**
     * 角色列表
     */
    public function index()
    {
        return view('admin.role.index', compact('roles'));
    }

    public function all()
    {

        $roles = Role::all();
        return $roles;
    }


}
