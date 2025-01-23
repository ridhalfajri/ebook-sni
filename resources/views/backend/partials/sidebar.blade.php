<div class="slim-sidebar">
    <label class="sidebar-label">Navigation</label>

    <ul class="nav nav-sidebar">
        <li class="sidebar-nav-item">
            <a href="{{route('dashboard.index')}}" class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}"><i class="icon ion-ios-home-outline"></i> Dashboard</a>
        </li>
        <li class="sidebar-nav-item with-sub">
            <a href="" class="sidebar-nav-link {{ request()->is('master-data*') ? 'active' : '' }}"><i class="icon ion-ios-book-outline"></i> Master Data</a>
            <ul class="nav sidebar-nav-sub">
                 <li class="nav-sub-item"><a href="{{route('categories.index')}}" class="nav-sub-link {{ request()->is('master-data/categories*') ? 'active' : '' }}">Categories</a></li>
                 <li class="nav-sub-item"><a href="{{route('ebooks.index')}}" class="nav-sub-link {{ request()->is('master-data/ebooks*') ? 'active' : '' }}">Ebook</a></li>
            </ul>
        </li>
    </ul>
</div>
