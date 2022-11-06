<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <li class="nav-item menu-open">
            <a href="{{ route('managerAdmin.dashboard') }}"
                class="nav-link {{ Request::routeIs('managerAdmin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fa-solid fa-house"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.schedule.index') }}"
                class="nav-link {{ Request::routeIs('managerAdmin.schedule.index') ? 'active' : '' }}">
                <i class="nav-icon  fa fa-calendar"></i>
                <p>
                    Schedules
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.admin.index') }}"
                class="nav-link {{ Request::routeIs('managerAdmin.admin.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-user">
                </i>

                <p>
                    Admins
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.star.index') }}"
                class="nav-link {{ Request::routeIs('managerAdmin.star.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-star"></i>
                <p>
                    Super Stars
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('managerAdmin.assigned.index') }}"
                class="nav-link {{ Request::routeIs('managerAdmin.assigned.index') ? 'active' : '' }}">
                <i class="nav-icon  fa-sharp fa-solid fa-door-open"></i>
                <p>
                    Assign
                </p>
            </a>
        </li>

        {{-- Promo Videos --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.promoVideo.published') || Request::routeIs('managerAdmin.promoVideo.pending') || Request::routeIs('managerAdmin.promoVideo.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-video-camera"></i>
                <p>Promo Videos
                    <i class="right fas fa-angle-left "></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.promoVideo.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.promoVideo.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.promoVideo.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.promoVideo.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Promo Videos End --}}

        {{-- Paid Post --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.simplePost') || Request::routeIs('managerAdmin.simplePost.published') || Request::routeIs('managerAdmin.simplePost.pending') || Request::routeIs('managerAdmin.simplePost.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-sharp fa-solid fa-signs-post"></i>
                <p>Paid Post
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.simplePost') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.simplePost') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.simplePost.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.simplePost.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.simplePost.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.simplePost.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Paid Post End --}}



        <li class="mt-3 px-2 mb-1" style="border-bottom: 1px solid rgb(112, 112, 112); color:rgb(112, 112, 112)">
            <h6>Events Modules</h6>
        </li>

        {{-- Live Chat --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.liveChat') || Request::routeIs('managerAdmin.liveChat.published') || Request::routeIs('managerAdmin.liveChat.pending') || Request::routeIs('managerAdmin.liveChat.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-comment-sms"></i>
                <p>Live Chat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.liveChat') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.liveChat') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.liveChat.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.liveChat.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.liveChat.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.liveChat.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Live Chat End --}}

        {{-- Question And Answers --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.qna') || Request::routeIs('managerAdmin.qna.published') || Request::routeIs('managerAdmin.qna.pending') || Request::routeIs('managerAdmin.qna.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-person-circle-question"></i>
                <p>Q & A
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.qna') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin..dashboard.qna') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.qna.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.qna.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.qna.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.qna.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Question And Answers End --}}

        {{-- Meetup Events --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.meetupEvent') || Request::routeIs('managerAdmin.meetupEvent.published') || Request::routeIs('managerAdmin.meetupEvent.pending') || Request::routeIs('managerAdmin.meetupEvent.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-handshake"></i>
                <p>Meetup Events

                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.meetupEvent') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.meetupEvent') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.meetupEvent.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.meetupEvent.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.meetupEvent.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.meetupEvent.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Meetup Events End --}}

        {{-- Greetings --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.greeting') || Request::routeIs('managerAdmin.greeting.request') || Request::routeIs('managerAdmin.greeting.published') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-heart"></i>
                <p>Greetings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.greeting') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.greeting') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.greeting.request') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.greeting.request') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Request</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.greeting.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.greeting.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Greetings End --}}

        {{-- Learning Session --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.learningSession') || Request::routeIs('managerAdmin.learningSession.evaluation') || Request::routeIs('managerAdmin.learningSession.published') || Request::routeIs('managerAdmin.learningSession.pending') || Request::routeIs('managerAdmin.learningSession.all') || Request::routeIs('managerAdmin.learningSession.rejected') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-chalkboard-user"></i>
                <p>Learning Session
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.learningSession') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.learningSession') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashbaord</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.evaluation') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.learningSession.evaluation') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Evaluation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.learningSession.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.learningSession.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.learningSession.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.learningSession.rejected') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.learningSession.rejected') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Rejected By Star</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Learning Session End --}}




        <li class="mt-3 px-2 mb-1" style="border-bottom: 1px solid rgb(112, 112, 112); color:rgb(112, 112, 112)">
            <h6>E- Showcase</h6>
        </li>

        {{-- Star Showcase --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.marketplace') || Request::routeIs('managerAdmin.marketplace.published') || Request::routeIs('managerAdmin.marketplace.pending') || Request::routeIs('managerAdmin.marketplace.all') || Request::routeIs('managerAdmin.marketplace.allOrderList') || Request::routeIs('managerAdmin.dashboard.auction') || Request::routeIs('managerAdmin.auctionProduct.published') || Request::routeIs('managerAdmin.auctionProduct.pending') || Request::routeIs('managerAdmin.auctionProduct.all') || Request::routeIs('managerAdmin.dashboard.souvenir') || Request::routeIs('managerAdmin.souvenir.published') || Request::routeIs('managerAdmin.souvenir.pending') || Request::routeIs('managerAdmin.souvenir.all') || Request::routeIs('managerAdmin.souvenir.showApply') || Request::routeIs('managerAdmin.souvenir.showApplyDelete') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                    E- Showcase
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li
                    class="nav-item {{ Request::routeIs('managerAdmin.dashboard.marketplace') || Request::routeIs('managerAdmin.marketplace.published') || Request::routeIs('managerAdmin.marketplace.pending') || Request::routeIs('managerAdmin.marketplace.all') || Request::routeIs('managerAdmin.marketplace.allOrderList') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-shop"></i>
                        <p>Marketplace
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.marketplace') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.dashboard.marketplace') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.published') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.marketplace.published') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.pending') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.marketplace.pending') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.all') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.marketplace.all') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.marketplace.allOrderList') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.marketplace.allOrderList') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Order List</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li
                    class="nav-item {{ Request::routeIs('managerAdmin.dashboard.souvenir') || Request::routeIs('managerAdmin.souvenir.published') || Request::routeIs('managerAdmin.souvenir.pending') || Request::routeIs('managerAdmin.souvenir.all') || Request::routeIs('managerAdmin.souvenir.showApply') || Request::routeIs('managerAdmin.souvenir.showApplyDelete') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-signature"></i>
                        <p>Souvenir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.souvenir') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.dashboard.souvenir') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.published') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.souvenir.published') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.pending') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.souvenir.pending') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.all') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.souvenir.all') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.showApply') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.souvenir.showApply') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Register List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.souvenir.showApplyDelete') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.souvenir.showApplyDelete') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Delete List</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <ul class="nav nav-treeview">
                <li
                    class="nav-item {{ Request::routeIs('managerAdmin.dashboard.auction') || Request::routeIs('managerAdmin.auctionProduct.published') || Request::routeIs('managerAdmin.auctionProduct.pending') || Request::routeIs('managerAdmin.auctionProduct.all') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-person-running"></i>
                        <p>Auction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.dashboard.auction') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.dashboard.auction') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.published') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.auctionProduct.published') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Published</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.pending') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.auctionProduct.pending') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('managerAdmin.auctionProduct.all') }}"
                                class="nav-link {{ Request::routeIs('managerAdmin.auctionProduct.all') ? 'active' : '' }}">
                                <i class="fa fa-arrow-right nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        {{-- Star Showcase End --}}

        {{-- Fan Group --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.fanGroup') || Request::routeIs('managerAdmin.fangroup.published') || Request::routeIs('managerAdmin.fangroup.pending') || Request::routeIs('managerAdmin.fangroup.all') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-people-group"></i>
                <p>Fan Group
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.fanGroup') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.fanGroup') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.fangroup.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.fangroup.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.fangroup.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.fangroup.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Fan Group End --}}


        <li class="mt-3 px-2 mb-1" style="border-bottom: 1px solid rgb(112, 112, 112); color:rgb(112, 112, 112)">
            <h6>Audition Management</h6>
        </li>
        {{-- Audition Managment --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.dashboard.audition') || Request::routeIs('managerAdmin.audition.events') || Request::routeIs('managerAdmin.audition.pending') || Request::routeIs('managerAdmin.audition.all') || Request::routeIs('managerAdmin.audition.published') || Request::routeIs('managerAdmin.audition.registration.rules') || Request::routeIs('managerAdmin.audition.auditionAdmin.index') || Request::routeIs('managerAdmin.audition.juries') || Request::routeIs('managerAdmin.audition.videoFeed') || Request::routeIs('managerAdmin.audition.roundResult') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">

                <i class="nav-icon fa-solid fa-person-skating"></i>

                <p>Audition Management
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.dashboard.audition') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.dashboard.audition') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>




                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.auditionAdmin.index') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.auditionAdmin.index') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Audition Admin</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.jury.index') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.jury.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gavel"></i>
                        <p>
                            Jury
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.events') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.events') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Events</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.pending') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.pending') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.all') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.all') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.published') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.published') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Published</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.registration.rules') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.registration.rules') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Audition Reg. Rules</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.juries') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.juries') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Juries</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.videoFeed') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.videoFeed') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Video Feed</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.audition.roundResult') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.audition.roundResult') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Results</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Audition Managment End --}}

        <li class="mt-3 px-2 mb-1" style="border-bottom: 1px solid rgb(112, 112, 112); color:rgb(112, 112, 112)">
            <h6>Accounts & Report</h6>
        </li>
        {{-- Accounts --}}
        <li class="nav-item {{ Request::routeIs('managerAdmin.accounts.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-user-pen"></i>
                <p>Accounts
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.accounts.index') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.accounts.index') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Accounts End --}}

        {{-- All Reports --}}
        <li
            class="nav-item {{ Request::routeIs('managerAdmin.report.audition') || Request::routeIs('managerAdmin.report.simplePost') || Request::routeIs('managerAdmin.report.learningSession') || Request::routeIs('managerAdmin.report.meetup') || Request::routeIs('managerAdmin.report.greeting') || Request::routeIs('managerAdmin.report.liveChat') || Request::routeIs('managerAdmin.report.qna') || Request::routeIs('managerAdmin.report.fanGroup') || Request::routeIs('managerAdmin.report.marketplace') || Request::routeIs('managerAdmin.report.auction') || Request::routeIs('managerAdmin.report.souvenir') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-user-pen"></i>
                <p>All Report
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.audition') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.audition') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Audition</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.simplePost') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.simplePost') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Paid Post</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.learningSession') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.learningSession') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Learning Session</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.meetup') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.meetup') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Meetup Event</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.greeting') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.greeting') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Greeting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.liveChat') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.liveChat') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Live Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.qna') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.qna') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Q&A</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.fanGroup') }}" class="nav-link {{ Request::routeIs('managerAdmin.report.fanGroup') ? 'active' : '' }}">
                       <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Fan Group</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.marketplace') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.marketplace') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Marketplace</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.auction') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.auction') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Auction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('managerAdmin.report.souvenir') }}"
                        class="nav-link {{ Request::routeIs('managerAdmin.report.souvenir') ? 'active' : '' }}">
                        <i class="fa fa-arrow-right nav-icon"></i>
                        <p>Souvenir</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- All Reports --}}


        <li style="height: 150px"></li>

    </ul>
</nav>
<!-- /.sidebar-menu -->
