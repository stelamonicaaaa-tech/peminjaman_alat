<aside id="sidebar"
    class="fixed top-0 left-0 w-64 h-screen bg-gradient-to-b from-gray-800 to-gray-900 text-white flex flex-col shadow-2xl -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">

    <!-- Logo/Brand Section -->
    <div class="p-6 border-b border-gray-700">

        <div class="flex items-center space-x-3 mb-4">
            <div
                class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                <i class='bx bx-box text-white text-xl'></i>
            </div>
            <h3 class="text-lg font-bold">Peminjaman Alat</h3>
        </div>

        <!-- User Info -->
        <div class="bg-gray-700/90 flex items-center justify-between rounded-lg p-3 backdrop-blur-sm">
            <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
            <span
                class="inline-block mt-1 px-2 py-0.5 bg-purple-500/20 text-purple-300 text-xs rounded-full border border-purple-500/30">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-4 overflow-y-auto">
        <ul class="space-y-1">

            @if (auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bxs-dashboard text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('users.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bxs-user-account text-lg {{ request()->routeIs('users.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Data User</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('kategori.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('kategori.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bxs-category text-lg {{ request()->routeIs('kategori.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Kategori</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'petugas')
                <li>
                    <a href="{{ route('petugas.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('petugas.dashboard') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bxs-dashboard text-lg {{ request()->routeIs('petugas.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'peminjam')
                <li>
                    <a href="{{ route('peminjam.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('peminjam.dashboard') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bxs-dashboard text-lg {{ request()->routeIs('peminjam.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'peminjam')
                <li>
                    <a href="{{ route('alat.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('alat.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bx-box text-lg {{ request()->routeIs('alat.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Alat</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ route('peminjaman.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('peminjaman.*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                    <i
                        class='bx bxs-cart-add text-lg {{ request()->routeIs('peminjaman.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                    <span class="font-medium text-sm">Peminjaman</span>
                </a>
            </li>

            <li>
                <a href="{{ route('pengembalian.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('pengembalian.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                    <i
                        class='bx bxs-package text-lg {{ request()->routeIs('pengembalian.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                    <span class="font-medium text-sm">Pengembalian</span>
                </a>
            </li>

            @if (auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('logAktivitas.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('logAktivitas.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg' : '' }}">
                        <i
                            class='bx bx-history text-lg {{ request()->routeIs('logAktivitas.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}'></i>
                        <span class="font-medium text-sm">Log Aktivitas</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    <!-- Logout Section -->
    <div class="p-4 border-t border-gray-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-600 hover:bg-red-700 rounded-lg font-medium text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class='bx bx-log-out text-lg'></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
