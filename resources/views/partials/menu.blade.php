<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route("admin.dashboard.index") }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">
                    {{ trans('cruds.dashboard.title') }}
                    </span>
                </a>
            </li>
            @can('user_management_access')
                <li>
                    <a class="has-arrow" href="#">
                        <i class="fa-fw fas fa-users nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.userManagement.title') }}</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('permission_access')
                            <li>
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                                    <span class="nav-text">{{ trans('cruds.permission.title') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li>
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon"></i>
                                    <span class="nav-text">{{ trans('cruds.role.title') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li>
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon"></i>
                                    <span class="nav-text">{{ trans('cruds.user.title') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('expense_category_access')
                <li>
                    <a href="{{ route("admin.expense-categories.index") }}" class="nav-link {{ request()->is('admin/expense-categories') || request()->is('admin/expense-categories/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.expenseCategory.title') }}<span class="nav-text">
                    </a>
                </li>
            @endcan
            @can('income_category_access')
                <li>
                    <a href="{{ route("admin.income-categories.index") }}" class="nav-link {{ request()->is('admin/income-categories') || request()->is('admin/income-categories/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.incomeCategory.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('expense_access')
                <li>
                    <a href="{{ route("admin.expenses.index") }}" class="nav-link {{ request()->is('admin/expenses') || request()->is('admin/expenses/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.expense.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('vendor_access')
                <li>
                    <a href="{{ route("admin.vendors.index") }}" class="nav-link {{ request()->is('admin/vendors') || request()->is('admin/vendors/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.vendor.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('income_access')
                <li>
                    <a href="{{ route("admin.incomes.index") }}" class="nav-link {{ request()->is('admin/incomes') || request()->is('admin/incomes/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.income.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('expense_report_access')
                <li>
                    <a href="{{ route("admin.expense-reports.index") }}" class="nav-link {{ request()->is('admin/expense-reports') || request()->is('admin/expense-reports/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.expenseReport.title') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>