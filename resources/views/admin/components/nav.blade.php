<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <a href="#" class="navbar-brand">線上購物後台管理系統</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                
            </ul>
            <div class="greeting-box">
                {!! $user_presenter->user_login_greeting() !!}
            </div>
        </div>
    </div>
</nav>