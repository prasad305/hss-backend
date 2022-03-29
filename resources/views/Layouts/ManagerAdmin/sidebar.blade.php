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
        <a href="{{ route('managerAdmin.admin.index') }}" class="nav-link">
          <i class="nav-icon {{ Request::routeIs('managerAdmin.admin.index') ? 'active' : '' }} fas fa-th"></i>
          <p>
             Admins
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('managerAdmin.auditionAdmin.index') }}" class="nav-link">
          <i class="nav-icon {{ Request::routeIs('managerAdmin.auditionAdmin.index') ? 'active' : '' }} fas fa-th"></i>
          <p>
            Audition Admins
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Post
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
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
        <p>Auction
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
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

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Marketplace
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
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

        {{-- </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Order</p>
            </a>
          </li> --}}
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
      </ul>
    </li>





    {{-- Creating gap --}}
    <li style="height: 150px"></li>
    {{-- Creating gap --}}





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