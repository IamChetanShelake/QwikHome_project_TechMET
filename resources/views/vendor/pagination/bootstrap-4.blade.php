@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mt-4 mb-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-modern shadow">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link prev-next" aria-label="@lang('pagination.previous')">
                            <i class="fas fa-angle-left"></i> Prev
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link prev-next" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                            <i class="fas fa-angle-left"></i> Prev
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link dots">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link active">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link number" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link prev-next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                            Next <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link prev-next" aria-label="@lang('pagination.next')">
                            Next <i class="fas fa-angle-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    <style>
        .pagination-modern {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 8px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            border: 1px solid #e1e5e9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .pagination-modern .page-item {
            margin: 0 2px;
        }

        .pagination-modern .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            margin: 0;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
            min-width: 42px;
            min-height: 42px;
        }

        /* Previous/Next buttons */
        .pagination-modern .page-link.prev-next {
            padding: 10px 18px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            font-weight: 500;
            border-radius: 8px;
        }

        .pagination-modern .page-link.prev-next:hover:not(.disabled) {
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .pagination-modern .page-item.disabled .page-link.prev-next {
            background: linear-gradient(135deg, #adb5bd 0%, #6c757d 100%);
            color: rgba(255, 255, 255, 0.6);
            cursor: not-allowed;
        }

        /* Number buttons */
        .pagination-modern .page-link.number {
            background: #fff;
            color: #6c757d;
            border: 1px solid #e1e5e9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .pagination-modern .page-link.number:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #343a40;
            border-color: #dee2e6;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Active page */
        .pagination-modern .page-item.active .page-link.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            font-weight: 600;
        }

        /* Disabled number buttons */
        .pagination-modern .page-item.disabled .page-link.dots {
            background: rgba(108, 117, 125, 0.05);
            color: #adb5bd;
            border: 1px solid #e1e5e9;
            cursor: default;
        }

        .pagination-modern .page-link i {
            font-size: 12px;
            margin: 0 4px;
        }

        .pagination-modern .page-link.prev-next i {
            font-size: 11px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .pagination-modern .page-link.prev-next {
                padding: 8px 12px;
                font-size: 13px;
            }
            .pagination-modern .page-link.number {
                padding: 8px 12px;
            }
        }
    </style>
@endif
