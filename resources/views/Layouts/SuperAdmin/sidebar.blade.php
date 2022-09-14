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
                    <a href="{{ route('superAdmin.auditionEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.auditionEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Auditions Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.meetupEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.meetupEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Meetup Events</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.learningSessionEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.learningSessionEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Learning Sessions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.liveChatEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.liveChatEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Live Chats</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.fanGroupEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.fanGroupEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Fan Group</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.greetingEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.greetingEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Greetings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.simplePostEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.simplePostEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Simple Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.qnaEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.qnaEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Q&A</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.marketplaceEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.marketplaceEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Marketplace</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.auctionEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.auctionEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Auction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.souvenirEvents.dashboard') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.souvenirEvents.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Souvenir</p>
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
            <a href="{{ route('superAdmin.simplePost.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.simplePost.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Simple Post
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
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bullhorn"></i>
                <p>
                    Audition
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.auditionList') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.auditionList') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Audtion List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-rules.index') }}" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-round-rules.index') }}" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Audition Round Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.auditionAdmin.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.auditionAdmin.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Audtion Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.jury_groups.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jury Groups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.userVoteMark.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Vote Mark</p>
                    </a>
                </li>
            </ul>
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
            <a href="{{ route('superAdmin.currency.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.currency.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-users"></i>
                <p>
                    Currency
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
            <a href="{{ route('superAdmin.occupation.index') }}" class="nav-link">
                <i class="nav-icon fa fa-map-signs"></i>
                <p>
                    Occupation
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                    Marketplace
                </p>
            </a>
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
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Marketplace
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
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Auction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superAdmin.auction.index') }}" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Dashboard</p>
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
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Souvenir
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
                    <a href="{{ route('superAdmin.liveChat.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Events</p>
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
                    <a href="{{ route('superAdmin.learningSession.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Events</p>
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
                    <a href="{{ route('superAdmin.meetupEvent.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Events</p>
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
                    <a href="{{ route('superAdmin.greeting.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Events</p>
                    </a>
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
                    <a href="{{ route('superAdmin.fanGroup.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Group</p>
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
                    <a href="{{ route('superAdmin.accounts.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Accounts Dashboard</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mb-5">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>All Report
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.all') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.simplePost') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Post</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.learningSession') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Learning Session</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.meetup') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Meetup Event</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.greeting') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Greeting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.liveChat') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Live Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.qna') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Q&A</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.fanGroup') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fan Group</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.marketplace') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Marketplace</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.auction') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Auction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.souvenir') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Souvenir</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
