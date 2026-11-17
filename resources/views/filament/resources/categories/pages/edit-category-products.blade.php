@php
    $business = $this->category->business;
    $products = $this->category->products()
        ->where('active', true)
        ->get();
@endphp

<x-filament-panels::page>
    <style>
        .page-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 36px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 16px;
            color: #6b7280;
            line-height: 1.6;
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .info-card-text {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .table-container {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(to right, #f3f4f6 0%, #e5e7eb 100%);
            border-bottom: 2px solid #d1d5db;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 18px 20px;
            font-size: 14px;
        }

        .product-name {
            font-weight: 500;
            color: #1f2937;
        }

        .current-price {
            background-color: #f3f4f6;
            padding: 8px 12px;
            border-radius: 4px;
            color: #4b5563;
            font-weight: 500;
            display: inline-block;
        }

        .price-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #3b82f6;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            color: #1f2937;
            background-color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .price-input:hover {
            border-color: #2563eb;
            background-color: #f0f9ff;
        }

        .price-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .price-input::placeholder {
            color: #9ca3af;
        }

        .no-products {
            padding: 60px 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 15px;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            gap: 16px;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            flex: 1;
            max-width: 300px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-cancel {
            background-color: #e5e7eb;
            color: #1f2937;
            border: 2px solid #d1d5db;
            min-width: 120px;
        }

        .btn-cancel:hover {
            background-color: #d1d5db;
            border-color: #9ca3af;
        }

        .tips-section {
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
            border-radius: 8px;
            padding: 24px;
            margin-top: 30px;
        }

        .tips-title {
            font-size: 16px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 16px;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-list li {
            font-size: 14px;
            color: #166534;
            margin-bottom: 10px;
            line-height: 1.6;
            padding-left: 0;
        }

        .tips-list li:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 0 15px;
            }

            .page-title {
                font-size: 28px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn-submit {
                max-width: 100%;
                width: 100%;
            }

            .btn-cancel {
                width: 100%;
            }

            th, td {
                padding: 12px 15px;
                font-size: 13px;
            }

            .price-input {
                padding: 10px 12px;
                font-size: 14px;
            }
        }
    </style>

    <form method="POST" action="#" onsubmit="return false;" wire:submit.prevent="savePrices">
        <div class="page-container">
            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">Edit Product Prices</h1>
                <p class="page-subtitle">
                    {{ $this->category->name_en }}
                    @if($business->language !== 'en')
                        <span style="color: #9ca3af;"> • {{ $this->category->name_ar }}</span>
                    @endif
                </p>
            </div>

            <!-- Info Cards -->
            <div class="info-cards-grid">
                <div class="info-card">
                    <div class="info-card-title">Total Products</div>
                    <div class="info-card-text">{{ $products->count() }} product(s) available</div>
                </div>
                <div class="info-card">
                    <div class="info-card-title">Edit Mode</div>
                    <div class="info-card-text">Click on price fields below to edit prices</div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40%;">Product Name</th>
                            <th style="width: 30%;">Current Price</th>
                            <th style="width: 30%;">New Price (Click to Edit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="product-name">
                                    @if($business->language === 'ar')
                                        {{ $product->name_ar }}
                                    @elseif($business->language === 'en')
                                        {{ $product->name_en }}
                                    @else
                                        <div>{{ $product->name_en }}</div>
                                        <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">{{ $product->name_ar }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="current-price">{{ number_format($product->price, 2) }}</span>
                                </td>
                                <td>
                                    <input 
                                        type="number"
                                        step="0.01"
                                        placeholder="Enter new price"
                                        wire:model="productPrices.{{ $product->id }}"
                                        class="price-input"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="no-products">
                                    No products found in this category
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <a
                    href="{{ route('filament.admin.resources.categories.index') }}"
                    class="btn btn-cancel"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-submit"
                >
                    Save All Changes
                </button>
            </div>

            <!-- Tips -->
            {{-- <div class="tips-section">
                <div class="tips-title">How to Edit Prices</div>
                <ul class="tips-list">
                    <li>Click on any blue price field to edit it</li>
                    <li>Enter the new price (use decimals like 10.99)</li>
                    <li>Review all changes before clicking "Save All Changes"</li>
                    <li>Click "Cancel" to discard changes and go back</li>
                </ul>
            </div> --}}
        </div>
    </form>
</x-filament-panels::page>
