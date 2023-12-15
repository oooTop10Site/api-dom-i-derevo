<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('main.edit') }}" class="brand-link">
        <img src="{{ Storage::url('logo.svg') }}" alt="Логитип XWEB" class="brand-image img-circle elevation-3 bg-white">
        <span class="brand-text font-weight-light">XWEB</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Storage::url('placeholder.webp') }}" class="img-circle elevation-2" alt="Placeholder пользователя">
            </div>
            <div class="info" style="color: #c2c7d0">Пользователь</div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('main.edit') }}" class="nav-link{{ request()->routeIs('main.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Главная</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('feedback.index') }}" class="nav-link{{ request()->routeIs('feedback.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>Обратная связь</p>
                    </a>
                </li>
                <li class="nav-item{{ request()->routeIs('service.*') ? ' menu-open' : '' }}">
                    <a href="#" class="nav-link{{ request()->routeIs('service.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Услуги
                            {!! request()->routeIs('service.*') ? '<i class="fas fa-angle-left right"></i>' : '<i class="right fas fa-angle-left"></i>' !!}
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('service.category.index') }}" class="nav-link{{ request()->routeIs('service.category.*') ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Категории</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('service.index') }}" class="nav-link{{ request()->routeIs('service.index') || request()->routeIs('service.create') || request()->routeIs('service.edit') ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Услуги</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('service.example.index') }}" class="nav-link{{ request()->routeIs('service.example.*') ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Примеры работ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item{{ request()->routeIs('blog.*') ? ' menu-open' : '' }}">
                    <a href="#" class="nav-link{{ request()->routeIs('blog.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Блог
                            {!! request()->routeIs('blog.*') ? '<i class="fas fa-angle-left right"></i>' : '<i class="right fas fa-angle-left"></i>' !!}
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('blog.category.index') }}" class="nav-link{{ request()->routeIs('blog.category.*') ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Категории</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.article.index') }}" class="nav-link{{ request()->routeIs('blog.article.*') ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Статьи</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('review.index') }}" class="nav-link{{ request()->routeIs('review.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-pen-nib"></i>
                        <p>Отзывы</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('information.index') }}" class="nav-link{{ request()->routeIs('information.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Информационные страницы</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link{{ request()->routeIs('user.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Пользователи</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
