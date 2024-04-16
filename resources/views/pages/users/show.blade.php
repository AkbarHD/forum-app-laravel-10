@extends('layout.app')

@section('title', 'Profile Akbar')

@section('body')
    <section class="bg-gray pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4 mb-5 mb-lg-0">
                    <div class="d-flex mb-4">
                        <div class="avatar-wrapper rounded-circle overflow-hidden flex-shrink-0 me-4">
                            <img src="{{ $picture }}" class="avatar" alt="avatar">
                        </div>

                        <div>
                            <div class="mb-4">
                                <div class="fs-2 fw-bold mb-1 lh-1 text-break">
                                    {{ $user->username }}
                                </div>
                                <div class="color-gray">
                                    Member since {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <input type="text" id="current-url" class="d-none" value="{{ request()->url() }}">
                        <a href="javascript:;" id="share-profile" class="btn btn-primary me-4">Share</a>
                        @auth
                            {{-- karena ini berdasarkan username jadi rentan utk di ganti maka kita bikin logic --}}
                            @if ($user->id === auth()->id())
                                <a href="{{ route('users.edit', $user->username) }}">Edit Profile</a>
                            @endif
                        @endauth
                    </div>

                </div>
                <div class="col-12 col-lg-8">
                    <div class="mb-5">
                        @forelse($discussions as $discussion)
                            <div class="card card-discussions">
                                <div class="row">
                                    <div
                                        class="col-12 col-lg-2 mb-1 mb-lg-0 d-flex flex-row flex-lg-column align-items-end">
                                        <div class="text-nowrap me-2 me-lg-0">
                                            {{ $discussion->likeCount . ' ' . Str::plural('like', $discussion->likeCount) }}
                                        </div>
                                        <div class="text-nowrap color-gray">
                                            {{ $discussion->answers->count() . ' ' . Str::plural('answers', $discussion->likeCount) }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <a href="{{ route('discussions.show', $discussion->slug) }}">
                                            <h3>{{ $discussion->title }}</h3>
                                        </a>
                                        <p>{!! $discussion->content_preview !!}</p>
                                        <div class="row">
                                            <div class="col me-1 me-lg-2">
                                                <a
                                                    href="{{ route('discussions.categories.show', $discussion->Category->slug) }}">
                                                    <span
                                                        class="badge rounded-pill text-bg-light">{{ $discussion->Category->name }}</span>
                                                </a>
                                            </div>
                                            <div class="col-5 col-lg-4">
                                                <div class="avatar-sm-wrapper d-inline-block">
                                                    <a href="{{ route('users.show', $discussion->User->username) }}"
                                                        class="me-1">
                                                        <img src="{{ filter_var($discussion->User->picture, FILTER_VALIDATE_URL) ? $discussion->User->picture : Storage::url($discussion->User->picture) }}"
                                                            class="avatar rounded-circle"
                                                            alt="{{ $discussion->User->username }}">
                                                    </a>
                                                </div>
                                                <span class="fs-12px">
                                                    <a href="#" class="me-1 fw-bold  text-break">
                                                        {{ $discussion->User->username }}
                                                    </a>
                                                    <span
                                                        class="color-gray">{{ $discussion->created_at->diffForHumans() }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card card-discussions">
                                <b>Currently no discussion yet</b>
                            </div>
                        @endforelse
                        {{ $discussions->appends(['answers' => $answers->currentPage()])->links() }}

                    </div>

                    <div>
                        <h2 class="mb-3">My Answer</h2>
                        <div>
                            @forelse ($answers as $answer)
                                <div class="card card-discussions">
                                    <div class="row align-items-center">
                                        <div class="col-2 col-lg-1 text-center">
                                            {{ $answer->likeCount }}
                                        </div>
                                        <div class="col-10 col-md-11">
                                            <span>Replied to</span>
                                            <span class="fw-bold text-primary">
                                                <a href="{{ route('discussions.show', $answer->discussion->slug) }}">
                                                    {{ $answer->discussion->title }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card  card-discussions">
                                    Currently no answer yet
                                </div>
                            @endforelse
                            {{ $answers->appends(['discussions' => $discussions->currentPage()])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('after-script')
    <script>
        $(document).ready(function() {
            $('#share-profile').click(function() {
                var copyText = $('#current-url');

                copyText[0].select();
                copyText[0].setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.val());

                var alert = $('#alert');
                alert.removeClass('d-none');

                var alertContainer = alert.find('.container');
                alertContainer.first().text('Link to this discussions copied successfully');
            });
        });
    </script>
@endsection
