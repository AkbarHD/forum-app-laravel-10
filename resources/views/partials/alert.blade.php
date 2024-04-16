<div id="alert" class="alert alert-success mb-0 rounded-0 d-none"
    @if (Session::has('notif.success')) style="display: block !important" @endif> {{-- jd ada sessio notif.success maka jadi d-block  --}}
    <div class="container">
        {{-- jd ada sessio notif.success maka get (ambil) value dari notif.scu --}}
        @if (Session::has('notif.success'))
            {{ Session::get('notif.success') }}
        @endif
    </div>
</div>
