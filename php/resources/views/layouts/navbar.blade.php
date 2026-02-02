<nav class="w-full flex flex-row items-center justify-between">
    <h1>{{strtoupper($pageHelper->getPage(request()->route()->getName()))}}</h1>
    <a
        href="{{ url('/dashboard') }}"
        class=""
    >
        Logout
    </a>
</nav>