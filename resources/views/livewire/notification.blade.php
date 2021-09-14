<div>
    <div class="menu-header-content bg-primary text-right" wire:poll>
        <div class="d-flex">
            <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الاشعارات</h6>
            <button wire:click="mark_as_read" class="badge badge-pill badge-warning mr-auto my-auto float-left">تعليم
                الكل كمقرؤء</button>
        </div>
        <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">لديك
            <strong>{{ auth()->user()->unreadNotifications->count() }}</strong> اشعارات غير مقرؤه</p>
    </div>
    <div class="main-message-list chat-scroll">
        @foreach (auth()->user()->unreadNotifications as $notification)
        <a href="{{ route('invoices.show', $notification->data['id']) }}" class="p-3 d-flex border-bottom">
            <div class="wd-90p">
                <div class="d-flex">
                    <h5 class="mb-1 name">{{ $notification->data['title'] . $notification->data['user'] }}</h5>
                </div>
                {{-- <p class="mb-0 desc">I'm sorry but i'm not sure how to help you with that......</p> --}}
                <p class="time mb-0 text-left float-right mr-2 mt-2">
                    {{ $notification->created_at->format('m-d h:s') }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>