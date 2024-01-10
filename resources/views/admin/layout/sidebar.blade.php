<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item m-menu__item--{{ $active_menu == 'dashboard' ? 'active' : '' }}" aria-haspopup="true" >
            <a  href="{{ route('admin.dashboard.view') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">
                            Dashboard
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Settings Section
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item m-menu__item--{{ $active_menu == 'settings' ? 'active' : '' }}" aria-haspopup="true" >
            <a  href="{{ route('admin.settings.view') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-settings-1"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">
                            Settings
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Users and Contacts
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'users' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.users.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-users"></i>
                <span class="m-menu__link-text">
                    Users
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'contacts' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.contacts.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-user"></i>
                <span class="m-menu__link-text">
                    Contacts
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Countries and Cities
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'countries' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.countries.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-placeholder"></i>
                <span class="m-menu__link-text">
                    Countries
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'cities' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.cities.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-placeholder-2"></i>
                <span class="m-menu__link-text">
                    Cities
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Companies and Branches
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'companies' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.companies.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-home-2"></i>
                <span class="m-menu__link-text">
                    Companies
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'branches' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.branches.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-infinity"></i>
                <span class="m-menu__link-text">
                    Branches
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'payments' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.payments.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-text">
                    Payments
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Items
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'items' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.items.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-open-box"></i>
                <span class="m-menu__link-text">
                    Items
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Invoices and Currencies
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'invoices' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.invoices.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-open-box"></i>
                <span class="m-menu__link-text">
                    Invoices
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'currencies' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.currencies.view') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-price-tag"></i>
                <span class="m-menu__link-text">
                    Currencies
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text m--font-section">
                Reports
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'reports_items' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
            <a  href="{{ route('admin.reports.items') }}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-text">
                    Revenue Report
                </span>
            </a>
        </li>
        {{--<li class="m-menu__item  m-menu__item--submenu m-menu__item--{{ $active_menu == 'reports_contacts' ? 'active' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">--}}
            {{--<a  href="{{ route('admin.reports.contacts') }}" class="m-menu__link m-menu__toggle">--}}
                {{--<i class="m-menu__link-icon flaticon-graphic"></i>--}}
                {{--<span class="m-menu__link-text">--}}
                    {{--Revenue By Contacts--}}
                {{--</span>--}}
            {{--</a>--}}
        {{--</li>--}}
    </ul>
</div>
