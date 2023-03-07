<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->


        <li
            class="nav-item {{ Request::routeIs('superAdmin.dashboard') || Request::routeIs('superAdmin.auditionEvents.dashboard') || Request::routeIs('superAdmin.learningSessionEvents.dashboard') || Request::routeIs('superAdmin.meetupEvents.dashboard') || Request::routeIs('superAdmin.liveChatEvents.dashboard') || Request::routeIs('superAdmin.fanGroupEvents.dashboard') || Request::routeIs('superAdmin.greetingEvents.dashboard') || Request::routeIs('superAdmin.simplePostEvents.dashboard') || Request::routeIs('superAdmin.qnaEvents.dashboard') || Request::routeIs('superAdmin.marketplaceEvents.dashboard') || Request::routeIs('superAdmin.auctionEvents.dashboard') || Request::routeIs('superAdmin.souvenirEvents.dashboard') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.dashboard') || Request::routeIs('superAdmin.auditionEvents.dashboard') || Request::routeIs('superAdmin.learningSessionEvents.dashboard') || Request::routeIs('superAdmin.meetupEvents.dashboard') || Request::routeIs('superAdmin.liveChatEvents.dashboard') || Request::routeIs('superAdmin.fanGroupEvents.dashboard') || Request::routeIs('superAdmin.greetingEvents.dashboard') || Request::routeIs('superAdmin.simplePostEvents.dashboard') || Request::routeIs('superAdmin.qnaEvents.dashboard') || Request::routeIs('superAdmin.marketplaceEvents.dashboard') || Request::routeIs('superAdmin.auctionEvents.dashboard') || Request::routeIs('superAdmin.souvenirEvents.dashboard') ? 'active' : '' }}">
                {{-- <i class="nav-icon fa fa-bullhorn"></i> --}}
                <i class="nav-icon fa fa-tachometer" aria-hidden="true"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>

                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  ">
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
            <a href="{{ route('superAdmin.showAllQuiz') }}"
                class="nav-link {{ Request::routeIs('superAdmin.showAllQuiz') ? 'active' : '' }}">
                <i class="fa fa-question-circle"> </i>
                <p>
                    Quize Result
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('superAdmin.category.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.category.index') ? 'active' : '' }}">
                {{-- <i class="nav-icon fas fa-edit"></i> --}}
                <i class=" nav-icon fa fa-list-alt" aria-hidden="true"></i>
                <p>
                    Category
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superAdmin.subCategory.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.subCategory.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-window-restore" aria-hidden="true"></i>

                <p>
                    Subcategory
                </p>
            </a>
        </li>


        <li
            class="nav-item {{ Request::routeIs('superAdmin.package.index') || Request::routeIs('superAdmin.love.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.package.index') || Request::routeIs('superAdmin.love.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-bullseye" aria-hidden="true"></i>
                <p>
                    Package
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.package.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.package.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>View Package</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superAdmin.love.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.love.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>View Love React</p>
                    </a>
                </li>

            </ul>
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
                <i class=" nav-icon fa-solid fa-film"></i>
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
            <a href="{{ route('superAdmin.withdraw.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.withdraw.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-television"></i>
                <p>
                    Withdraw Request
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superAdmin.auction.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.auction.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-television"></i>
                <p>
                    Auction Instruction and Terms
                </p>
            </a>
        </li>

        <li
            class="nav-item {{ Request::routeIs('superAdmin.virtual-tour.index') || Request::routeIs('superAdmin.greeting-type.index') || Request::routeIs('superAdmin.interest-type.index') || Request::routeIs('superAdmin.currency.index') || Request::routeIs('superAdmin.country.index') || Request::routeIs('superAdmin.state.index') || Request::routeIs('superAdmin.city.index') || Request::routeIs('superAdmin.educationlevel.index') || Request::routeIs('superAdmin.occupation.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.greeting-type.index') || Request::routeIs('superAdmin.interest-type.index') || Request::routeIs('superAdmin.currency.index') || Request::routeIs('superAdmin.country.index') || Request::routeIs('superAdmin.state.index') || Request::routeIs('superAdmin.city.index') || Request::routeIs('superAdmin.educationlevel.index') || Request::routeIs('superAdmin.occupation.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-sliders" aria-hidden="true"></i>
                <p>Settings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.virtual-tour.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.virtual-tour.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Virtual Tour
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.greeting-type.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.greeting-type.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Greeting Type
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.interest-type.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.interest-type.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Interest Type
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.currency.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.currency.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Currency
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.country.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.country.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Country
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.state.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.state.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            State
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superAdmin.city.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.city.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            City
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.educationlevel.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.educationlevel.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Education level
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superAdmin.occupation.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.occupation.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Occupation
                        </p>
                    </a>
                </li>

            </ul>
        </li>
        <li
            class="nav-item {{Request::routeIs('superAdmin.occupation.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{Request::routeIs('superAdmin.occupation.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-sliders" aria-hidden="true"></i>
                <p>Delivery Charge
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.marketplacedeliverycharge.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.marketplacedeliverycharge.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Marketplace Delivery Charge
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.souvenirdeliverycharge.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.souvenirdeliverycharge.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Souvenir Delivery Charge
                        </p>
                    </a>
                </li>

            </ul>
        </li>

        <li
            class="nav-item {{ Request::routeIs('superAdmin.aboutUs.index') || Request::routeIs('superAdmin.privacy.index') || Request::routeIs('superAdmin.faq.index') || Request::routeIs('superAdmin.productpurchase.index') || Request::routeIs('superAdmin.refundpolicy.index') || Request::routeIs('superAdmin.termscondition.index') || Request::routeIs('superAdmin.faq.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bullseye" aria-hidden="true"></i>
                <p>
                    Landing Settings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.aboutUs.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.aboutUs.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>About us</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superAdmin.privacy.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.privacy.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Privacy policy</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.productpurchase.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.productpurchase.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Product purchase</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.refundpolicy.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.refundpolicy.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Refund Policy</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.termscondition.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.termscondition.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Terms And Condition</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.faq.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.faq.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>FAQ</p>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('superAdmin.loveReactPrice.index') }}"
                class="nav-link {{ Request::routeIs('superAdmin.loveReactPrice.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Paid Love React
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
        <li class="nav-item {{ Request::routeIs('superAdmin.liveChat.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('superAdmin.liveChat.index') ? 'active' : '' }}">
                <i class=" nav-icon fa fa-comments" aria-hidden="true"></i>
                <p>Live Chat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.liveChat.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.liveChat.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Events</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::routeIs('superAdmin.qna.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('superAdmin.qna.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-question-circle" aria-hidden="true"></i>
                <p>Q&A
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.qna.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.qna.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Events</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::routeIs('superAdmin.learningSession.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.learningSession.index') ? 'active' : '' }}">
                <i class="nav-icon fa-solid fa-school"></i>
                <p>Learning Session
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.learningSession.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.learningSession.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Events</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::routeIs('superAdmin.meetupEvent.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.meetupEvent.index') ? 'active' : '' }}">
                <i class="nav-icon fa-brands fa-meetup"></i>
                <p>Meetup Events
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.meetupEvent.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.meetupEvent.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Events</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::routeIs('superAdmin.greeting.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('superAdmin.greeting.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-id-card" aria-hidden="true"></i>
                <p>Greetings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.greeting.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.greeting.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Events</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::routeIs('superAdmin.fanGroup.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('superAdmin.fanGroup.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-users" aria-hidden="true"></i>
                <p>Fan Group
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.fanGroup.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.fanGroup.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>All Group</p>
                    </a>
                </li>
            </ul>
        </li>
        {{--
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                    Marketplace
                </p>
            </a>
        </li> --}}
        <li
            class="nav-item {{ Request::routeIs('superAdmin.marketplace.dashboard') || Request::routeIs('superAdmin.auction.dashboard') || Request::routeIs('superAdmin.souvenir.dashboard') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.marketplace.dashboard') || Request::routeIs('superAdmin.auction.dashboard') || Request::routeIs('superAdmin.souvenir.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fa fa-id-card" aria-hidden="true"></i>
                <p>
                    Star Showcase
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item {{ Request::routeIs('superAdmin.marketplace.dashboard') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs('superAdmin.marketplace.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            Marketplace
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superAdmin.marketplace.dashboard') }}"
                                class="nav-link {{ Request::routeIs('superAdmin.marketplace.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>All Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item {{ Request::routeIs('superAdmin.auction.dashboard') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs('superAdmin.auction.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-gavel" aria-hidden="true"></i>
                        <p>
                            Auction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superAdmin.auction.dashboard') }}"
                                class="nav-link {{ Request::routeIs('superAdmin.auction.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>All Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item {{ Request::routeIs('superAdmin.souvenir.dashboard') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs('superAdmin.souvenir.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gift"></i>
                        <p>
                            Souvenir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superAdmin.souvenir.dashboard') }}"
                                class="nav-link {{ Request::routeIs('superAdmin.souvenir.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>All Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li
            class="nav-item {{ Request::routeIs('superAdmin.auditionList') || Request::routeIs('superAdmin.audition-rules.index') || Request::routeIs('superAdmin.superAdmin.audition-rules.edit') || Request::routeIs('superAdmin.audition-round-rules.index') || Request::routeIs('superAdmin.auditionAdmin.index') || Request::routeIs('superAdmin.jury_groups.index') || Request::routeIs('superAdmin.userVoteMark.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.auditionList') || Request::routeIs('superAdmin.audition-rules.index') || Request::routeIs('superAdmin.audition-round-rules.index') || Request::routeIs('superAdmin.auditionAdmin.index') || Request::routeIs('superAdmin.jury_groups.index') || Request::routeIs('superAdmin.userVoteMark.index') ? 'active' : '' }}">
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
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Audtion List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-rules.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.audition-rules.index') ? 'active' : '' }} ">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Audition Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.audition-round-rules.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.audition-round-rules.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Audition Round Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.auditionAdmin.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.auditionAdmin.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>
                            Audtion Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.jury_groups.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.jury_groups.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Jury Groups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.userVoteMark.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.userVoteMark.index') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>User Vote Mark</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item {{ Request::routeIs('superAdmin.accounts.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('superAdmin.accounts.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-sort-amount-asc" aria-hidden="true"></i>
                <p>Accounts
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.accounts.index') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.accounts.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-caret-right nav-icon"></i>
                        <p>Accounts Dashboard</p>
                    </a>
                </li>
            </ul>
        </li>
        <li
            class="nav-item mb-5 {{ Request::routeIs('superAdmin.report.audition') || Request::routeIs('superAdmin.report.simplePost') || Request::routeIs('superAdmin.report.learningSession') || Request::routeIs('superAdmin.report.meetup') || Request::routeIs('superAdmin.report.greeting') || Request::routeIs('superAdmin.report.liveChat') || Request::routeIs('superAdmin.report.qna') || Request::routeIs('superAdmin.report.auction') || Request::routeIs('superAdmin.report.marketplace') || Request::routeIs('superAdmin.report.souvenir') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::routeIs('superAdmin.report.audition') || Request::routeIs('superAdmin.report.simplePost') || Request::routeIs('superAdmin.report.learningSession') || Request::routeIs('superAdmin.report.meetup') || Request::routeIs('superAdmin.report.greeting') || Request::routeIs('superAdmin.report.liveChat') || Request::routeIs('superAdmin.report.qna') || Request::routeIs('superAdmin.report.auction') || Request::routeIs('superAdmin.report.marketplace') || Request::routeIs('superAdmin.report.souvenir') ? 'active' : '' }}">
                </i><i class="nav-icon fa fa-file" aria-hidden="true"></i>
                <p>All Report
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.audition') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.audition') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Audition</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.simplePost') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.simplePost') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Simple Post</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.learningSession') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.learningSession') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Learning Session</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.meetup') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.meetup') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Meetup Event</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.greeting') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.greeting') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Greeting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.liveChat') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.liveChat') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Live Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.qna') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.qna') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Q&A</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('superAdmin.report.fanGroup') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fan Group</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.marketplace') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.marketplace') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Marketplace</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.auction') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.auction') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Auction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superAdmin.report.souvenir') }}"
                        class="nav-link {{ Request::routeIs('superAdmin.report.souvenir') ? 'active' : '' }}">
                        <i class="fas fa-caret-right nav-icon"></i>
                        <p>Souvenir</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
