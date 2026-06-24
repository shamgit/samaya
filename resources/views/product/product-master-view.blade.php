@include('layouts.header')
@include('layouts.sidebar')

<main class="main-content">

    <!-- PAGE HEADER -->
    <div class="page-header">

        <a href="{{ route('product_master') }}"
            class="back-title">

            <h1 class="page-title">

                <i class="bi bi-chevron-left"></i>

                View - {{ $product->product_code }}

            </h1>

        </a>

    </div>


    <!-- DETAIL CARD -->
    <div class="detail-card">

        <!-- Product Details -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">

                    Product Details

                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <!-- Image -->
                    <tr class="info-row">

                        <td class="info-label">

                            Product Image

                        </td>

                        <td class="info-value">

                            <div class="d-flex gap-3">

                                <div class="up-img">

                                    @if($product->product_image)

                                        <img src="{{ asset('uploads/products/'.$product->product_image) }}"
                                            class="img-fluid"
                                            width="120">

                                    @else

                                        <img src="{{ asset('images/no-image.png') }}"
                                            class="img-fluid"
                                            width="120">

                                    @endif

                                </div>

                            </div>

                        </td>

                    </tr>

                    <!-- Product Name -->
                    <tr class="info-row">

                        <td class="info-label">

                            Product Name

                        </td>

                        <td class="info-value">

                            {{ $product->product_name }}

                        </td>

                    </tr>

                    <!-- Product Code -->
                    <tr class="info-row">

                        <td class="info-label">

                            Product Code

                        </td>

                        <td class="info-value">

                            {{ $product->product_code }}

                        </td>

                    </tr>

                    <!-- Category -->
                    <tr class="info-row">

                        <td class="info-label">

                            Category

                        </td>

                        <td class="info-value">

                            {{ $product->category_name ?? 'No Category' }}

                        </td>

                    </tr>

                    <!-- Measure -->
                    <tr class="info-row">

                        <td class="info-label">

                            Unit Measure

                        </td>

                        <td class="info-value">

                            {{ $product->unit_of_measure }}

                        </td>

                    </tr>

                    <!-- Color -->
                    <tr class="info-row">

                        <td class="info-label">

                            Product Color

                        </td>

                        <td class="info-value">

                            {{ $product->product_color }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- Supplier -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">

                    Supplier & Price

                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <!-- Supplier -->
                    <tr class="info-row">

                        <td class="info-label">

                            Supplier Name

                        </td>

                        <td class="info-value">

                            {{ $product->supplier_name ?? 'No Supplier' }}

                        </td>

                    </tr>

                    <!-- Cost -->
                    <tr class="info-row">

                        <td class="info-label">

                            Cost / Price

                        </td>

                        <td class="info-value">

                            ₹{{ $product->cost_price }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- Inventory -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">

                    Inventory Setting

                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <!-- Reorder -->
                    <tr class="info-row">

                        <td class="info-label">

                            Reorder Level

                        </td>

                        <td class="info-value">

                            {{ $product->reorder_level }}

                        </td>

                    </tr>

                    <!-- Warehouse -->
                    <tr class="info-row">

                        <td class="info-label">

                            Warehouse Location

                        </td>

                        <td class="info-value">

                            {{ $product->warehouse_location }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</main>

@include('layouts.footer')
@include('layouts.scripts')