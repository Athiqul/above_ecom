<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rukada</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>

            <a href="{{route('vendor.dashboard') }}" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>

        </li>

        @if (Auth::user()->status=='active')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>

                <li> <a href="{{ route('vendor.product.list') }}"><i class="bx bx-right-arrow-alt"></i>All Products</a>
                </li>
                <li> <a href="{{ route('product.add') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
                </li>

            </ul>
        </li>
        @endif



    </ul>
    <!--end navigation-->
</div>
