<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper d-flex align-items-center gap-2">
            <a href="" class="d-flex align-items-center">
                <img style="width: 100px;" class="img-fluid for-light" src="{{ asset('assets/images/mcware-logo.png') }}"
                    alt="Logo">
                <img style="width: 100px;" class="img-fluid for-dark" src="{{ asset('assets/images/mcware-logo.png') }}"
                    alt="Logo Dark">
            </a>
            <h3 class="mb-0 ms-1 fw-bold">
                {{ auth()->user()->hasRole('admin') ? 'Admin' : 'User' }}
            </h3>
            <div class="back-btn ms-3"><i class="fa fa-angle-left"></i></div>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>

            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">


                    <li class="back-btn">
                        <a href="{{ url('/') }}">

                        </a>
                        <div class="mobile-back text-end"><span>Back</span></div>
                    </li>

                    @role('user')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav"
                                href="{{ route('admin.users.show', auth()->id()) }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41
                                                                                C7.7649 4.246 10.0149 2 11.9579 2
                                                                                C13.8999 2 16.1949 4.235 17.6539 5.41
                                                                                C20.9589 8.475 21.5719 8.082 21.5719 13.713
                                                                                C21.5719 22 19.6129 22 11.9859 22
                                                                                C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" />
                                        </g>
                                    </g>
                                </svg>
                                <span>Profile</span>
                            </a>

                        </li>
                    @endrole


                    @role('admin')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.users.index') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41C7.7649 4.246 10.0149 2 11.9579 2
                                                                                                            C13.8999 2 16.1949 4.235 17.6539 5.41C20.9589 8.475 21.5719 8.082 21.5719 13.713
                                                                                                            C21.5719 22 19.6129 22 11.9859 22C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" />
                                        </g>
                                    </g>
                                </svg>
                                <span>User List</span>
                            </a>
                        </li>
                    @endrole
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('tickets.index') }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <g>
                                    <g>
                                        <path d="M8.54248 9.21777H15.3975" stroke="#130F26" stroke-width="1.5" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9702 2.5C5.58324 2.5 4.50424 3.432 4.50424 10.929
                                            C4.50424 19.322 4.34724 21.5 5.94324 21.5
                                            C7.53824 21.5 10.1432 17.816 11.9702 17.816
                                            C13.7972 17.816 16.4022 21.5 17.9972 21.5
                                            C19.5932 21.5 19.4362 19.322 19.4362 10.929
                                            C19.4362 3.432 18.3572 2.5 11.9702 2.5Z" stroke="#130F26"
                                            stroke-width="1.5" />
                                    </g>
                                </g>
                            </svg>
                            <span>Tickets</span>
                        </a>
                    </li>

                    @role('admin')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('installations.index') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41
                                                                                C7.7649 4.246 10.0149 2 11.9579 2
                                                                                C13.8999 2 16.1949 4.235 17.6539 5.41
                                                                                C20.9589 8.475 21.5719 8.082 21.5719 13.713
                                                                                C21.5719 22 19.6129 22 11.9859 22
                                                                                C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" />
                                        </g>
                                    </g>
                                </svg>
                                <span>Installations</span>
                            </a>

                        </li>
                    @endrole
                    @role('admin')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('complaints.index') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <g>
                                            <path d="M8.54248 9.21777H15.3975" stroke="#130F26" stroke-width="1.5" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9702 2.5C5.58324 2.5 4.50424 3.432 4.50424 10.929
                                                C4.50424 19.322 4.34724 21.5 5.94324 21.5
                                                C7.53824 21.5 10.1432 17.816 11.9702 17.816
                                                C13.7972 17.816 16.4022 21.5 17.9972 21.5
                                                C19.5932 21.5 19.4362 19.322 19.4362 10.929
                                                C19.4362 3.432 18.3572 2.5 11.9702 2.5Z" stroke="#130F26"
                                                stroke-width="1.5" />
                                        </g>
                                    </g>
                                </svg>
                                <span>Whatsapp Complaints</span>
                            </a>
                        </li>
                    @endrole


                    @role('admin')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41
                                                                            C7.7649 4.246 10.0149 2 11.9579 2
                                                                            C13.8999 2 16.1949 4.235 17.6539 5.41
                                                                            C20.9589 8.475 21.5719 8.082 21.5719 13.713
                                                                            C21.5719 22 19.6129 22 11.9859 22
                                                                            C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" />
                                        </g>
                                    </g>
                                </svg>
                                <span>Masters</span>
                            </a>

                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('corporations.index') }}">Corporations</a>
                                </li>
                                <li>
                                    <a href="{{ route('zones.index') }}">Zones</a>
                                </li>
                                <li>
                                    <a href="{{ route('constituencies.index') }}">Constituencies</a>
                                </li>
                                <li>
                                    <a href="{{ route('wards.index') }}">Wards</a>
                                </li>
                            </ul>

                        </li>
                    @endrole




                </ul>
            </div>

            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
