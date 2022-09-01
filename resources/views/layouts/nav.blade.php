<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <!--  <div>
                    <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div> -->
        <div>
            <h4 class="logo-text">Green Accounting</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('home') }}" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                <li> <a href="{{ route('general.show') }}"><i class="bx bx-right-arrow-alt"></i>General Setup</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Items Operation</div>
            </a>
            <ul>
            <li> <a href="{{ route('categories') }}"><i class="bx bx-right-arrow-alt"></i>Category</a>
                </li>
                <li> <a href="{{ route('items') }}"><i class="bx bx-right-arrow-alt"></i>Item List</a>
                </li>
                <li> <a href="{{ route('blends') }}"><i class="bx bx-right-arrow-alt"></i>Blend Manage</a>
                </li>
                <li> <a href="{{ route('item.stock') }}"><i class="bx bx-right-arrow-alt"></i>Stock</a>
                </li>
               
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-spa'></i>
                </div>
                <div class="menu-title">Sales</div>
            </a>
            <ul>
                <li> <a href="{{ route('invoices') }}"><i class="bx bx-right-arrow-alt"></i>Invoices</a>
                </li>
                <li> <a href="{{ route('customers') }}"><i class="bx bx-right-arrow-alt"></i>Customer</a>
                </li>
                <li> <a href="{{ route('salereturns') }}"><i class="bx bx-right-arrow-alt"></i>Sale Return</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart-alt'></i>
                </div>
                <div class="menu-title">Purchase</div>
            </a>
            <ul>
                <li> <a href="{{ route('purchases') }}"><i class="bx bx-right-arrow-alt"></i>Purchase</a>
                </li>
                <li> <a href="{{ route('vendors') }}"><i class="bx bx-right-arrow-alt"></i>Vendors</a>
                </li>
                <li> <a href="{{ route('purchasereturns') }}"><i class="bx bx-right-arrow-alt"></i>Puchase Return</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-gift'></i>
                </div>
                <div class="menu-title">Banking</div>
            </a>
            <ul>
                <li> <a href="{{ route('accounts') }}"><i class="bx bx-right-arrow-alt"></i>Accounts</a>
                </li>
                <li> <a href="{{ route('payments') }}"><i class="bx bx-right-arrow-alt"></i>Transection</a>
                </li>
                <li> <a href="{{ route('transfers') }}"><i class="bx bx-right-arrow-alt"></i>Transfer</a>
                <li> <a href="{{ route('expenses') }}"><i class="bx bx-right-arrow-alt"></i>Expense</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('reports') }}">
                <div class="parent-icon"><i class='bx bx-command'></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>

        </li>
        <li>
            <a class="has-arrow" href="{{ route('users') }}">
                <div class="parent-icon"><i class='bx bx-command'></i>
                </div>
                <div class="menu-title">User</div>
            </a>

        </li>

    </ul>
    <!--end navigation-->
</div>
