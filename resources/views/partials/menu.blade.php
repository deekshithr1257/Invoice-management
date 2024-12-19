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
                    <ul aria-expanded="true">
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

            @can('invoice_category_access')
                <li>
                    <a href="{{ route("admin.invoice-categories.index") }}" class="nav-link {{ request()->is('admin/invoice-categories') || request()->is('admin/invoice-categories/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.invoiceCategory.title') }}<span class="nav-text">
                    </a>
                </li>
            @endcan
            @can('payment_category_access')
                <li>
                    <a href="{{ route("admin.payment-categories.index") }}" class="nav-link {{ request()->is('admin/payment-categories') || request()->is('admin/payment-categories/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.paymentCategory.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('invoice_access')
                <li>
                    <a href="{{ route("admin.invoices.index") }}" class="nav-link {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.invoice.title') }}</span>
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
            @can('payment_access')
                <li>
                    <a href="{{ route("admin.payments.index") }}" class="nav-link {{ request()->is('admin/payments') || request()->is('admin/payments/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.payment.title') }}</span>
                    </a>
                </li>
            @endcan
            @can('invoice_report_access')
                <li>
                    <a href="{{ route("admin.invoice-reports.index") }}" class="nav-link {{ request()->is('admin/invoice-reports') || request()->is('admin/invoice-reports/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">{{ trans('cruds.invoiceReport.title') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
