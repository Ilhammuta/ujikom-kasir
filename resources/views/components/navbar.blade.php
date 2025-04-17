<header class="flex justify-between items-center bg-white p-4 shadow rounded-lg">
    <input type="text" placeholder="Search" class="border p-2 rounded-lg w-1/3">

    <div class="relative">
        <button id="avatarBtn" class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center text-white shadow-md hover:bg-orange-300 transition">
            <i class="fi fi-rr-user text-lg"></i>
        </button>

        <div id="dropdownMenu"
            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
            <a href=""
                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M9.75 6a2.25 2.25 0 0 1 4.5 0v.75h-4.5V6z" />
                    <path
                        d="M4.5 9.75A2.25 2.25 0 0 1 6.75 7.5h10.5a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 18.75v-9z" />
                </svg>
                {{ Auth::user()->name }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 border-t">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    avatarBtn.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!avatarBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
