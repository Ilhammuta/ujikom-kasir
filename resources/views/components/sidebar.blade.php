<aside class="w-64 bg-white shadow-lg p-5">
    <h1 class="text-2xl font-bold text-blue-600 flex items-center gap-2">
        FlexyLite
    </h1>
    <nav class="mt-5">
        <ul>
            <li class="mb-2">
                <a href="{{ Auth::user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.petugas') }}"
                    class="flex items-center p-3 rounded-lg 
                    {{ request()->routeIs('dashboard.admin') || request()->routeIs('dashboard.petugas') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    <i class="fi fi-rr-home mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('produk.index') }}"
                    class="flex items-center p-3 rounded-lg 
                   {{ request()->routeIs('produk.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    <i class="fi fi-rr-box mr-3"></i>
                    Produk
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('penjualan.index') }}"
                    class="flex items-center p-3 rounded-lg 
                   {{ request()->routeIs('penjualan.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    <i class="fi fi-rr-shopping-cart mr-3"></i>
                    Pembelian
                </a>
            </li>
            <li class="mb-2">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('user.index') }}"
                            class="flex items-center p-3 rounded-lg 
           {{ request()->routeIs('user.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                            <i class="fi fi-rr-user mr-3"></i>
                            User
                        </a>
                    @endif
                @endauth
            </li>
        </ul>
    </nav>
</aside>
