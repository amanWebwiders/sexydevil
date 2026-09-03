@php
    $allFaqs = \App\Models\Faq::where('status', 1)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
    $faqCategories = $allFaqs->pluck('category')->unique()->filter()->values();
@endphp

@if($allFaqs->isNotEmpty())
<div class="faq-footer-section my-5">
    <div class="container">
        <div class="faq-wrapper">
            <!-- FAQ Header -->
            <div class="text-center mb-4">
                <span class="faq-badge">KNOWLEDGE BASE</span>
                <h2 class="faq-main-title mt-2">FREQUENTLY ASKED QUESTIONS</h2>
                <p class="faq-subtitle text-muted">Find quick answers to common questions about advertising, verification, and our escort directory.</p>
            </div>

            <!-- Category Filter Tabs -->
            @if($faqCategories->count() > 1)
            <div class="faq-category-tabs d-flex justify-content-center flex-wrap gap-2 mb-4">
                <button type="button" class="faq-tab-btn active" data-category="all">
                    <i class="fa-solid fa-layer-group me-1"></i> All Questions
                </button>
                @foreach($faqCategories as $cat)
                <button type="button" class="faq-tab-btn" data-category="{{ Str::slug($cat) }}">
                    @if(Str::contains(strtolower($cat), 'advertis'))
                        <i class="fa-solid fa-bullhorn me-1"></i>
                    @elseif(Str::contains(strtolower($cat), ['member', 'visitor']))
                        <i class="fa-solid fa-user-group me-1"></i>
                    @else
                        <i class="fa-solid fa-circle-question me-1"></i>
                    @endif
                    {{ $cat }}
                </button>
                @endforeach
            </div>
            @endif

            <!-- Collapsible FAQ Accordion -->
            <div class="faq-accordion-list">
                @foreach($allFaqs as $index => $faq)
                <div class="faq-item" data-category="{{ Str::slug($faq->category) }}">
                    <button type="button" class="faq-question-btn" aria-expanded="false" id="faq-btn-{{ $faq->id }}">
                        <span class="faq-icon-box">
                            <i class="fa-solid fa-plus faq-toggle-icon"></i>
                        </span>
                        <span class="faq-question-title">{{ $faq->question }}</span>
                        @if($faq->category)
                            <span class="faq-cat-tag d-none d-md-inline-block">{{ $faq->category }}</span>
                        @endif
                    </button>
                    <div class="faq-answer-panel" id="faq-panel-{{ $faq->id }}">
                        <div class="faq-answer-content">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .faq-footer-section {
        position: relative;
        z-index: 10;
        text-align: left;
    }
    .faq-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 30px 20px;
        background: rgba(18, 18, 18, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }
    .faq-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #e41e3f;
        background: rgba(228, 30, 63, 0.12);
        border: 1px solid rgba(228, 30, 63, 0.3);
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .faq-main-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #ffffff;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .faq-subtitle {
        font-size: 14px;
        max-width: 620px;
        margin: 0 auto;
        color: #a0a0a0 !important;
    }
    .faq-category-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 16px;
    }
    .faq-tab-btn {
        background: #1a1a1a;
        color: #cccccc;
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 7px 18px;
        border-radius: 24px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .faq-tab-btn:hover {
        background: #252525;
        color: #ffffff;
        border-color: rgba(228, 30, 63, 0.4);
    }
    .faq-tab-btn.active {
        background: #e41e3f;
        color: #ffffff;
        border-color: #e41e3f;
        box-shadow: 0 4px 14px rgba(228, 30, 63, 0.4);
    }
    .faq-accordion-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .faq-item {
        background: #151515;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        overflow: hidden;
        transition: border-color 0.25s ease, background 0.25s ease;
    }
    .faq-item:hover {
        border-color: rgba(228, 30, 63, 0.35);
    }
    .faq-item.active {
        background: #181818;
        border-color: rgba(228, 30, 63, 0.5);
    }
    .faq-question-btn {
        width: 100%;
        background: transparent;
        border: none;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-align: left;
        cursor: pointer;
        outline: none;
        user-select: none;
    }
    .faq-icon-box {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 6px;
        background: #222222;
        border: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e41e3f;
        font-size: 13px;
        transition: all 0.25s ease;
    }
    .faq-item.active .faq-icon-box {
        background: #e41e3f;
        color: #ffffff;
        border-color: #e41e3f;
    }
    .faq-question-title {
        flex: 1;
        font-size: 15px;
        font-weight: 600;
        color: #f1f1f1;
        line-height: 1.4;
        transition: color 0.2s ease;
    }
    .faq-item:hover .faq-question-title,
    .faq-item.active .faq-question-title {
        color: #ffffff;
    }
    .faq-cat-tag {
        font-size: 11px;
        color: #888888;
        background: rgba(255, 255, 255, 0.05);
        padding: 3px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }
    .faq-answer-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .faq-answer-content {
        padding: 0 20px 18px 62px;
        font-size: 14px;
        line-height: 1.65;
        color: #bbbbbb;
        border-top: 1px dashed rgba(255, 255, 255, 0.06);
        margin-top: 2px;
        padding-top: 12px;
    }
    @media (max-width: 767px) {
        .faq-wrapper {
            padding: 20px 12px;
        }
        .faq-main-title {
            font-size: 20px;
        }
        .faq-question-title {
            font-size: 14px;
        }
        .faq-question-btn {
            padding: 12px 14px;
            gap: 10px;
        }
        .faq-answer-content {
            padding: 8px 14px 14px 14px;
            font-size: 13px;
        }
    }
</style>

<script>
(function() {
    function initFaqModule() {
        // 1. Accordion Toggle
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const btn = item.querySelector('.faq-question-btn');
            const panel = item.querySelector('.faq-answer-panel');
            const icon = item.querySelector('.faq-toggle-icon');

            if (!btn || !panel) return;

            btn.onclick = function(e) {
                e.preventDefault();
                const isOpen = item.classList.contains('active');

                if (isOpen) {
                    item.classList.remove('active');
                    btn.setAttribute('aria-expanded', 'false');
                    panel.style.maxHeight = null;
                    if (icon) {
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                    }
                } else {
                    item.classList.add('active');
                    btn.setAttribute('aria-expanded', 'true');
                    panel.style.maxHeight = panel.scrollHeight + "px";
                    if (icon) {
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus');
                    }
                }
            };
        });

        // 2. Category Tab Filtering
        const tabBtns = document.querySelectorAll('.faq-tab-btn');
        tabBtns.forEach(tab => {
            tab.onclick = function(e) {
                e.preventDefault();
                tabBtns.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const targetCategory = this.getAttribute('data-category');

                faqItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    if (targetCategory === 'all' || itemCategory === targetCategory) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                        // Collapse if hidden
                        item.classList.remove('active');
                        const panel = item.querySelector('.faq-answer-panel');
                        const icon = item.querySelector('.faq-toggle-icon');
                        if (panel) panel.style.maxHeight = null;
                        if (icon) {
                            icon.classList.remove('fa-minus');
                            icon.classList.add('fa-plus');
                        }
                    }
                });
            };
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFaqModule);
    } else {
        initFaqModule();
    }
})();
</script>
@endif
