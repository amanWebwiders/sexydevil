@if(isset($breadcrumbs) && is_array($breadcrumbs) && count($breadcrumbs) > 0)
<nav aria-label="breadcrumb" class="py-2 px-3 mb-3 rounded breadcrumb-nav" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
    <ol class="breadcrumb mb-0 bg-transparent p-0" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ url('/') }}" itemprop="item" class="text-light">
                <span itemprop="name"><i class="fa fa-home mr-1"></i> Home</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        @foreach($breadcrumbs as $index => $crumb)
            <li class="breadcrumb-item {{ $loop->last ? 'active text-warning font-weight-bold' : '' }}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                @if(!$loop->last && !empty($crumb['url']))
                    <a href="{{ $crumb['url'] }}" itemprop="item" class="text-light">
                        <span itemprop="name">{{ $crumb['title'] }}</span>
                    </a>
                @else
                    <span itemprop="name">{{ $crumb['title'] }}</span>
                @endif
                <meta itemprop="position" content="{{ $index + 2 }}" />
            </li>
        @endforeach
    </ol>
</nav>
@endif
