<nav>
    <a href="{{ route('home') }}" class="site-title">線上購物系統</a>
    <ul class="nav-list">
        <li>
            <a href="">最新商品</a>
        </li>
        <li>
            <a href="">熱門商品</a>
        </li>
        <li>
            <a href="">限時折扣</a>
        </li>
        <li>
            <a href="{{ route('cart.home') }}">購物車</a>
        </li>
        <li>
            <a href="javascript:showMemberAreaList();" class="member-area">會員專區 <i class="fa fa-caret-down" aria-hidden="true"></i></a>
            <ul class="member-area-list">
                <li>
                    <a href="">我的訂單</a>
                </li>
                <li>
                    <a href="">推薦好康</a>
                </li>
                @if (!is_array(session()->get('user')) || empty(session()->get('user')))
                    <li>
                        <a href="{{ route('user.login') }}">會員登入</a>
                    </li>
                @else
                    <li>
                        <a href="javascript:userLogout();">會員登出</a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
    @if (is_array(session()->get('user')) && !empty(session()->get('user')))
        <span class="login-greeting">{{ session()->get('user')['name'] }}，您好!</span>
    @endif
    <a href="javascript:showSearchBox();" class="search-box-switch">
        <i class="fa fa-search" aria-hidden="true"></i>
    </a>
    <!-- 搜尋區塊 -->
    <form class="search-box" method="GET" action="{{ route('merchandise.search') }}">
        <!-- 搜尋商品名稱或描述 -->
        <div class="search-condition">
            <label>關鍵字搜尋</label><br>
            <input type="text" id="search-keyword-input" name="search-keyword-input" placeholder="商品名稱">
        </div>
        <!-- 搜尋商品價格 -->
        <div class="search-condition">
            <label>商品價格</label><br>
            <input type="number" id="search-min-price-input" name="search-min-price-input" placeholder="商品最低價">
            <span>到</span>
            <input type="number" id="search-max-price-input" name="search-max-price-input" placeholder="商品最高價">
        </div>
        <!-- 搜尋商品上架日期 -->
        <div class="search-condition">
            <label>商品上架日期</label><br>
            <input type="date" id="put-on-init-date" name="put-on-init-date">
            <span>到</span>
            <input type="date" id="put-on-end-date" name="put-on-end-date">
        </div>
        <!-- 搜尋按鈕 -->
        <button class="search-merchandise-btn" type="submit">
            搜尋
        </button>
    </form>
</nav>