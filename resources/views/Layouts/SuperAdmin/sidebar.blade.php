<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->


        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.dashboard') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Main Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.auditions') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.auditions') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Auditions Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.meetupEvents') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.meetupEvents') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Meetup Events</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.learningSessions') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.learningSessions') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Learning Sessions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.liveChats') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.liveChats') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Live Chats</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.fanGroup') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.fanGroup') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Fan Group</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.greetings') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.greetings') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Greetings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.userPosts') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.userPosts') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>User Posts</p>
                    </a>
                </li>
               
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.category.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.category.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Category
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Package
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.package.index') }}"
                    class="nav-link {{ Request::routeIs('superAdmin.package.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Package</p>
                    </a>
                </li>
            
              
            </ul>
        </li>


        <li class="nav-item">
            <a href="{{ route('superAdmin.subCategory.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.subCategory.index') ? 'active' : '' }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                    Subcategory
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.managerAdmin.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.managerAdmin.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-user"> </i>
                <p>
                    Manager Admin
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('superAdmin.audition.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.audition.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Audtion
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Audtion
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-dashboard.index') }}"
                    class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-rules.index') }}"
                    class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-round-rules.index') }}"
                    class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Round Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-admin.index') }}"
                    class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admins</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=""
                    class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manager</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-jury.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jurys</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/charts/flot.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Result</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.auditionAdmin.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.auditionAdmin.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Audtion Admin
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.admin.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.admin.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-users"></i>
                <p>
                    Admin
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.star.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.star.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-television"></i>
                <p>
                    Super Star
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.jury.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.jury.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-television"></i>
                <p>
                    Jury
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.greeting-type.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.greeting-type.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-video-camera"></i>
                <p>
                    Greeting Type
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.interest-type.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.interest-type.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Interest Type
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.country.index') }}" class="nav-link">
                <i class="nav-icon fa fa-flag"></i>
                <p>
                    Country
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.state.index') }}" class="nav-link">
                <i class="nav-icon fa fa-flag-o"></i>
                <p>
                    State
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.city.index') }}" class="nav-link">
                <i class="nav-icon fa fa-map-signs"></i>
                <p>
                    City
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('superAdmin.marketplace.index') }}" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                    Marketplace
                </p>
            </a>
        </li>

        {{-- Gap For Future --}}
        <div style="height: 150px"></div>
        {{-- Gap For Future --}}

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Live Chat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                    UI Elements
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/UI/general.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/icons.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Icons</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/buttons.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Buttons</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/sliders.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sliders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/modals.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Modals & Alerts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/navbar.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Navbar & Tabs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/timeline.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Timeline</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/ribbons.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ribbons</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Forms
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/forms/general.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General Elements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/forms/advanced.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Advanced Elements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/forms/editors.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Editors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/forms/validation.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Validation</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Tables
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/tables/simple.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/data.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>DataTables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/jsgrid.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>jsGrid</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-header">EXAMPLES</li>
        <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                    Calendar
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                    Gallery
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="pages/kanban.html" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                    Kanban Board
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-envelope"></i>
                <p>
                    Mailbox
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/mailbox/mailbox.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inbox</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/mailbox/compose.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Compose</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/mailbox/read-mail.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Read</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Pages
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/examples/invoice.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Invoice</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/profile.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/e-commerce.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>E-commerce</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/projects.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Projects</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/project-add.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Project Add</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/project-edit.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Project Edit</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/project-detail.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Project Detail</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/contacts.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Contacts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/faq.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>FAQ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/contact-us.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Contact us</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                    Extras
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Login & Register v1
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/examples/login.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Login v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/register.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/forgot-password.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Forgot Password v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/recover-password.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Recover Password v1</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Login & Register v2
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/examples/login-v2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Login v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/register-v2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/forgot-password-v2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Forgot Password v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/recover-password-v2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Recover Password v2</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/lockscreen.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Lockscreen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/legacy-user-menu.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Legacy User Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/language-menu.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Language Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/404.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Error 404</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/500.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Error 500</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/pace.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pace</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/blank.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Blank Page</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Starter Page</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>
                    Search
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/search/simple.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Search</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/search/enhanced.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Enhanced</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-header">MISCELLANEOUS</li>
        <li class="nav-item">
            <a href="iframe.html" class="nav-link">
                <i class="nav-icon fas fa-ellipsis-h"></i>
                <p>Tabbed IFrame Plugin</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>Documentation</p>
            </a>
        </li>
        <li class="nav-header">MULTI LEVEL EXAMPLE</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                <p>Level 1</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-circle"></i>
                <p>
                    Level 1
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Level 2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Level 2
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Level 3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Level 3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Level 3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Level 2</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                <p>Level 1</p>
            </a>
        </li>
        <li class="nav-header">LABELS</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Important</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Warning</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Informational</p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
