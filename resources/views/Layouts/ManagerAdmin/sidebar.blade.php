<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="{{ route('managerAdmin.dashboard') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.schedule.index') }}" class="nav-link">
                <i class="nav-icon {{ Request::routeIs('managerAdmin.schedule.index') ? 'active' : '' }} fas fa-th"></i>
                <p>
                    Schedules
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('managerAdmin.admin.index') }}" class="nav-link">
                <i class="nav-icon {{ Request::routeIs('managerAdmin.admin.index') ? 'active' : '' }} fas fa-users">
                </i>
                {{-- <i class="fa-solid fa-list-check"></i> --}}
                <p>
                    Admins
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.star.index') }}" class="nav-link">
                <i class="nav-icon {{ Request::routeIs('managerAdmin.star.index') ? 'active' : '' }} fas fa-star"></i>
                <p>
                    Super Stars
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.jury.index') }}" class="nav-link">
                <i class="nav-icon {{ Request::routeIs('managerAdmin.jury.index') ? 'active' : '' }} fas fa-th"></i>
                <p>
                    Jury
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.assigned.index') }}" class="nav-link">
                <i
                    class="nav-icon {{ Request::routeIs('managerAdmin.assigned.index') ? 'active' : '' }} fas fa-th"></i>
                <p>
                    Assign
                </p>
            </a>
        </li>




        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Simple Post
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.simplePost') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Promo Videos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Greetings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.greeting') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.greeting.request') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Request</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.greeting.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Star Showcase
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Marketplace
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.marketplace') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.published') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.pending') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.all') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.allOrderList') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order List</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Auction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.auction') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.published') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.pending') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.all') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Souvenir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.souvenir') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.published') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.pending') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.all') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.showApply') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.showApplyDelete') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delete List</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Fan Group
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.fanGroup') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Meetup Events

                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.meetupEvent') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Live Chat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.liveChat') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
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
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Learning Session
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.learningSession') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashbaord</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.evaluation') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Evaluation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.rejected') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rejected By Star</p>
                    </a>
                </li>
            </ul>
        </li>


        <li
            class="nav-item {{ \Illuminate\Support\Facades\Request::is('manager-admin/audition*') ? 'menu-open ' : '' }}">
            <a href="#"
                class="nav-link {{ \Illuminate\Support\Facades\Request::is('manager-admin/audition*') ? 'active ' : '' }}">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Audition Management
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.audition') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.events') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Events</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.registration.rules') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Reg. Rules</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.auditionAdmin.index') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.auditionAdmin.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admins</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.juries') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Juries</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.roundResult') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Results</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Question And Answers --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Q&A
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.qna') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.published') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Accounts
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.accounts.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Creating gap --}}
        <li style="height: 150px"></li>
        {{-- Creating gap --}}

    </ul>
</nav>
<!-- /.sidebar-menu -->
