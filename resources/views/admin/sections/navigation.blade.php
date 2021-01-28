<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">Navigation</li>
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
                </li>
                <li class="has_sub {{ (request()->is('customer*')) ? 'active' : '' }}">
                    <a href="{{route('admin.customer.index')}}" class="waves-effect"><i class="fa fa-users"></i> <span> Khách hàng </span></a>
                </li>

{{--                <li class="has_sub {{ (request()->is('comment*')) ? 'active' : '' }}">--}}
{{--                    <a href="{{route('admin.comment.index')}}" class="waves-effect"><i class="md-comment"></i> <span> Bình luận </span></a>--}}
{{--                </li>--}}
                <li class="has_sub {{ request()->is('category*') || request()->is('product*') || request()->is('tag*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="waves-effect"><i
                            class="fa fa-shopping-cart"></i><span>Sản phẩm </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ (request()->is('news/create')) ? 'active' : '' }}">
                            <a href="{{route('admin.product.create')}}"><span><i class="fa fa-cart-plus m-r-5"></i> Đăng sản phẩm</span></a>
                        </li>
                        <li class="{{ (request()->is('news/index')) ? 'active' : '' }}">
                            <a href="{{route('admin.news.index')}}"><span><i class="fa fa-hacker-news m-r-5"></i> Danh sách</span></a>
                        </li>
                        <li class="{{ (request()->is('category*')) ? 'active' : '' }}">
                            <a href="{{route('admin.category.index')}}">
                                <span><i class="fa fa-folder-open-o m-r-5"></i> Loại sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--                <li class="has_sub {{ request()->is('category*') || request()->is('news*') || request()->is('tag*') ? 'active' : '' }}">--}}
                {{--                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-newspaper-o"></i><span>Tin tức </span> <span class="menu-arrow"></span></a>--}}
                {{--                    <ul>--}}
                {{--                        <li class="{{ (request()->is('news/create')) ? 'active' : '' }}">--}}
                {{--                            <a href="{{route('admin.news.create')}}"><span><i class="fa fa-plane m-r-5"></i> Đăng tin</span></a>--}}
                {{--                        </li>--}}
                {{--                        <li class="{{ (request()->is('news/index')) ? 'active' : '' }}">--}}
                {{--                            <a href="{{route('admin.news.index')}}"><span><i class="fa fa-hacker-news m-r-5"></i> Danh sách tin</span></a>--}}
                {{--                        </li>--}}
                {{--                        <li class="{{ (request()->is('category*')) ? 'active' : '' }}">--}}
                {{--                            <a href="{{route('admin.category.index')}}"><span><i class="fa fa-folder-open-o m-r-5"></i></span> Chuyên mục</span></a>--}}
                {{--                        </li>--}}
                {{--                        <li class="{{ (request()->is('tag*')) ? 'active' : '' }}">--}}
                {{--                            <a href="{{route('admin.tag.index')}}"><span><i class="fa fa-tags m-r-5"></i> Tag</span></a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                <li class="has_sub {{ (request()->is('config*')) ? 'active' : '' }}">
                    <a href="{{route('admin.config.index')}}" class="waves-effect"><i class="fa fa-cog"></i> <span> Cài đặt </span></a>
                </li>
                <li class="has_sub {{ (request()->is('feedback*')) ? 'active' : '' }}">
                    <a href="{{route('admin.feedback.index')}}" class="waves-effect"><i class="fa fa-comments-o"></i>
                        <span> Feedback </span></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
