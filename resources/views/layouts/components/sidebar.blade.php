<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Dashboard</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @canany(['view products', 'create products', 'view print barcodes', 'view inventory transfer'])
                <li class="menu-title" key="t-menu">Catalog</li>
                @endcanany

                @can('view products')
                <li>
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span>View Products</span>
                    </a>
                </li>
                @endcan

                @can('create products')
                <li>
                    <a href="{{ route('products.create') }}" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                @endcan

                @can('view print barcodes')
                <li>
                    <a href="{{ route('products.print-barcodes') }}" class="waves-effect">
                        <i class="bx bx-printer"></i>
                        <span>Print Barcodes</span>
                    </a>
                </li>
                @endcan
 
                @can('view inventory transfer')
                <li>
                    <a href="{{ route('inventory-history') }}" class="waves-effect">
                        <i class="fas fa-truck fs-5"></i>
                        <span>Inventory Transfer History</span>
                    </a>
                </li>
                @endcan
                
                @can('view inventory transfer')
                <li>
                    <a href="{{ route('inventory-transfer.index') }}" class="waves-effect">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Inventory Transfer</span>
                    </a>
                </li>
                @endcan

               
                @can('view inventory transfer')
                <li>
                    <a href="{{ route('purchase-orders.index') }}" class="waves-effect">
                        <i class="fas fa-box"></i>
                        <span>Purchase Orders</span>
                    </a>
                </li>
                @endcan

                <li>
                    <a href="{{ route('collections.index') }}" class="waves-effect">
                        <i class="bx bx-collection"></i>
                        <span>Collections</span>
                    </a>
                </li>

                @canany(['view departments', 'view product types', 'view brands', 'view colors', 'view size scales', 'view tags', 'view branches', 'view customers', 'view users', 'view suppliers', 'view role', 'view roles & permissions', 'view tax', 'view settings', 'view price reasons'])
                <li class="menu-title">Settings</li>
                @endcanany
                
                @canany(['view departments', 'view product types', 'view brands', 'view colors', 'view size scales', 'view tags'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-package"></i>
                            <span>Product Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view departments')
                            <li><a href="{{ route('departments.index') }}">Departments</a></li>
                            @endcan

                            @can('view product types')
                            <li><a href="{{ route('product-types.index') }}">Product Types</a></li>
                            @endcan
            
                            @can('view brands')
                            <li><a href="{{ route('brands.index') }}">Brands</a></li>
                            @endcan
            
                            @can('view colors')
                            <li><a href="{{ route('colors.index') }}">Colors</a></li>
                            @endcan
            
                            @can('view size scales')
                            <li><a href="{{ route('size-scales.index') }}">Size Scales</a></li>
                            @endcan
            
                            @can('view tags')
                            <li><a href="{{ route('tags.index') }}">Tags</a></li>
                            @endcan 
 
                        </ul>
                    </li>
                @endcanany

                @canany(['view branches', 'view customers', 'view users', 'view suppliers', 'view role', 'view roles & permissions', 'view tax', 'view settings', 'view price reasons'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>System Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('view branches')
                        <li><a href="{{ route('branches.index') }}">Branches</a></li>
                        @endcan

                        @can('view customers')
                        <li><a href="#">Customers</a></li>
                        @endcan

                        @can('view users')
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                        @endcan

                        @can('view suppliers')
                        <li><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        @endcan

                        @can('view role')
                        <li><a href="{{ route('roles-and-permissions.role-list') }}">Roles</a></li>
                        @endcan

                        @can('view roles & permissions')
                        <li><a href="{{ route('roles-and-permissions.index') }}">Permissions</a></li>
                        @endcan

                        @can('view tax')
                        <li><a href="{{ route('tax-settings.index') }}">Tax</a></li>
                        @endcan

                        @can('view settings')
                        <li><a href="{{ route('settings.index') }}">Default Images</a></li>
                        @endcan

                        @can('view price reasons')
                        <li><a href="{{ route('change-price-reasons.index') }}">Change Price Reasons</a></li>
                        @endcan

                        @can('view settings')
                        <li><a href="{{ route('general-settings.index') }}">General</a></li>
                        @endcan

                        @can('view settings')
                        <li><a href="{{ route('web-settings.index') }}">Web Settings</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>