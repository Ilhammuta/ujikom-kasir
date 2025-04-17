<aside class="bg-white shadow-lg p-5 w-full sm:w-64 min-h-screen">
    <h1 class="text-2xl font-bold text-blue-600 flex items-center gap-2">
        <i class="fi fi-rr-layers"></i> FlexyLite
    </h1>

    <nav class="mt-6">
        <ul class="space-y-2">
            <li>
                <a href="{{ Auth::user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.petugas') }}"
                    class="flex items-center p-3 rounded-lg transition
                    {{ request()->routeIs('dashboard.admin') || request()->routeIs('dashboard.petugas') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fi fi-rr-home mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('produk.index') }}"
                    class="flex items-center p-3 rounded-lg transition
                    {{ request()->routeIs('produk.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fi fi-rr-box mr-3"></i>
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}"
                    class="flex items-center p-3 rounded-lg transition
                    {{ request()->routeIs('penjualan.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fi fi-rr-shopping-cart mr-3"></i>
                    Penjualan
                </a>
            </li>
            @auth
                @if (Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="flex items-center p-3 rounded-lg transition
                            {{ request()->routeIs('user.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fi fi-rr-user mr-3"></i>
                            User
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </nav>
</aside>
