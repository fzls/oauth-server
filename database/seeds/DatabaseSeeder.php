<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
                'username' => 'Rem',
                'email'    => 'Rem@gmail.com',
                'phone'    => '15700072333',
                'avatar'   => 'www.meow.com/pic/233',
                'password' => bcrypt('meow_meow'),
            ],
            [
                'username' => 'Lem',
                'email'    => 'Lem@gmail.com',
                'phone'    => '15700076666',
                'avatar'   => 'www.meow.com/pic/666',
                'password' => bcrypt('meow_meow'),
            ],
        ];
        foreach ($users as $user) {
            \App\User::create($user);
        }

        $roles = [
            [
                'name'        => 'admin',
                'description' => '系统管理员，负责对系统进行维护',
            ],
            [
                'name'        => 'user',
                'description' => '普通用户',
            ],
        ];
        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }

        $user_roles = [
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
            [
                'user_id' => 1,
                'role_id' => 2,
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
            ],
        ];
        foreach ($user_roles as $user_role) {
            \App\Models\UserRole::create($user_role);
        }

        $permissions = [
            [
                'name'        => 'view',
                'description' => '查看一般权限的东西',
            ],
            [
                'name'        => 'operate_gift',
                'description' => '是否具有对礼物进行操作的权限',
            ],
            [
                'name'        => 'operate_history',
                'description' => '是否具有对历史行程进行操作的权限',
            ],
            [
                'name'        => 'operate_user',
                'description' => '是否具有对用户信息进行操作的权限',
            ],
        ];
        foreach ($permissions as $permission) {
            \App\Models\Permission::create($permission);
        }

        $role_permissions = [
            [
                'role_id'=>1,
                'permission_id'=>1
            ],
            [
                'role_id'=>1,
                'permission_id'=>2
            ],
            [
                'role_id'=>1,
                'permission_id'=>3
            ],
            [
                'role_id'=>1,
                'permission_id'=>4
            ],
            [
                'role_id'=>2,
                'permission_id'=>1
            ],
        ];
        foreach ($role_permissions as $role_permission) {
            \App\Models\RolePermission::create($role_permission);
        }
    }
}
