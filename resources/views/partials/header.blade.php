<!-- resources/views/partials/_header.blade.php -->
<header class="bg-white shadow-sm sticky top-0 z-50">
  <div class="container mx-auto px-4 py-3">
    <div class="flex items-center justify-between">
      <!-- Mobile menu button -->
      <button id="mobileMenuToggle" class=" focus:outline-none" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex-shrink-0">
        <img src="/uploads/images/mukora-logo.png" alt="Mukora Supermarket" class="h-9">
      </a>

      <!-- Search -->
      <div class="relative flex-1 mx-4 hidden md:block">
        <input id="desktopSearch" type="text" name="search" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-orange-200" placeholder="Search products, brands, categories">
        <button id="desktopSearchBtn" class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Go</button>
      </div>

      <!-- Actions -->
      <div class="flex items-center space-x-4">
        <!-- Account -->
        <div class="relative">
          <button id="accountToggle" class="flex items-center focus:outline-none" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-user-circle text-xl"></i>
            <span class="ml-1 hidden lg:inline">Account</span>
            <i class="fas fa-chevron-down ml-1 text-sm hidden lg:inline"></i>
          </button>
          <ul id="accountMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg">
            @auth
              <li><a href="{{ route('user.profile') }}" class="block px-4 py-2 hover:bg-gray-100">My Profile</a></li>
              <li><a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">My Orders</a></li>
              <li><hr class="my-1"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                </form>
              </li>
            @else
              <li><a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100">Login</a></li>
              <li><a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100">Register</a></li>
            @endauth
          </ul>
        </div>

        <!-- Help -->
        <div class="relative hidden lg:block">
          <button id="helpToggle" class="flex items-center focus:outline-none" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-question-circle text-xl"></i>
            <span class="ml-1">Help</span>
            <i class="fas fa-chevron-down ml-1 text-sm"></i>
          </button>
          <ul id="helpMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg">
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Customer Service</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">FAQs</a></li>
            <li><a href="{{ route('contact') }}" class="block px-4 py-2 hover:bg-gray-100">Contact Us</a></li>
          </ul>
        </div>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="flex items-center relative" id="cartLink">
          <i class="fas fa-shopping-cart text-xl"></i>
          <span id="cartCount" class="absolute -top-1 -right-2 bg-yellow-500 text-black text-xs rounded-full px-1">{{ session('cart') ? count(session('cart')) : 0 }}</span>
          <span class="ml-2 hidden lg:inline">Cart</span>
        </a>
      </div>
    </div>

    <!-- Mobile menu -->
    
  </div>

  <!-- Breadcrumb -->
  <div class="bg-gray-800 border-t border-gray-700">
    <div class="container mx-auto px-4 py-2">
      <nav aria-label="breadcrumb">
        <ol class="flex text-sm text-gray-300">
          <li><a href="{{ route('home.index') }}" class="hover:text-white">Home</a></li>
          @if(!empty($breadcrumbs))
            @foreach($breadcrumbs as $bc)
              <li class="mx-2">/</li>
              @if($loop->last)
                <li class="text-gray-100">{{ $bc['name'] }}</li>
              @else
                <li><a href="{{ $bc['url'] }}" class="hover:text-white">{{ $bc['name'] }}</a></li>
              @endif
            @endforeach
          @endif
        </ol>
      </nav>
    </div>
  </div>
  <div id="mobileDropdown" class="hidden absolute top-12 left-2 z-50 bg-white rounded-sm shadow-md border border-gray-200 max-w-xs">
  <ul class="py-0">
    @foreach($categories as $cat)
      <li>
        <a href="{{ route('categories.show', ['category' => $cat->slug]) }}" 
           class="flex items-center px-2 py-1 hover:bg-gray-50 transition-colors duration-200 text-gray-700">
          <span class="text-xs">{{ $cat->name }}</span>
        </a>
      </li>
    @endforeach
  </ul>
</div>
</header>

<style>
  #mobileDropdown ul { list-style: none; padding: 0; margin: 0; }
  /* Transition for menus */
  #mobileDropdown, #accountMenu, #helpMenu { transition: max-height 0.3s ease; overflow: hidden; }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Utility to toggle visibility with animation
    function toggleMenu(button, menu) {
      button.addEventListener('click', e => {
        e.preventDefault(); e.stopPropagation();
        if (menu.style.maxHeight) {
          menu.style.maxHeight = null;
          setTimeout(() => menu.classList.add('hidden'), 300);
        } else {
          menu.classList.remove('hidden');
          menu.style.maxHeight = menu.scrollHeight + 'px';
        }
      });
      document.addEventListener('click', e => { if (!button.contains(e.target)) {
        menu.style.maxHeight = null;
        setTimeout(() => menu.classList.add('hidden'), 300);
      }});
    }

    // Mobile toggle
    const mobileBtn = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileDropdown');
    mobileBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    // Account & Help
    toggleMenu(document.getElementById('accountToggle'), document.getElementById('accountMenu'));
    toggleMenu(document.getElementById('helpToggle'), document.getElementById('helpMenu'));

    // Search interactivity
    const searchInput = document.getElementById('desktopSearch');
    const searchBtn = document.getElementById('desktopSearchBtn');
    searchBtn.addEventListener('click', () => {
      const query = searchInput.value.trim();
      if (query) window.location.href = `{{ route('products.index') }}?search=` + encodeURIComponent(query);
    });
    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') searchBtn.click(); });

    // Update cart count live (example event listener)
    window.addEventListener('cart-updated', e => {
      document.getElementById('cartCount').textContent = e.detail.count;
    });
  });
</script>
