@extends('layout.app')

@section('title', 'Detail Discussions')
@section('body')
    <div class="bg-gray pt-5 pb-5">
        <div class="container">

            <div class="mb-5">
                <div class="d-flex align-items-center">
                    <div class="d-flex">
                        <div class="fs-2 fw-bold color-gray me-2 mb-0">Disscussion</div>
                        <div class="fs-2 fw-bold color-gray me-2 mb-0">></div>
                    </div>
                    <h2 class="mb-0">{{ $discussion->title }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8 mb-5 mb-lg-0">
                    <div class="card card-discussions mb-5">
                        <div class="row">
                            <div class="col-1 d-flex flex-column justify-content-start align-items-center">
                                {{-- $discussion->liked utk menandakan dia udh ngelike apa blm --}}
                                <a id="discussion-like" href="javascript:;" data-liked="{{ $discussion->liked() }}">
                                    <img src="{{ $discussion->liked() ? $likedImage : $notLikedImage }}"
                                        class="like-icon mb-1" id="discussion-like-icon" alt="like">
                                </a>
                                <span id="discussion-like-count"
                                    class="fs-4 color-gray mb-1">{{ $discussion->likeCount }}</span>
                            </div>
                            <div class="col-11">
                                <div>
                                    {!! $discussion->content !!}
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('discussions.categories.show', $discussion->Category->slug) }}">
                                        <span
                                            class="badge rounded-pill text-bg-light">{{ $discussion->Category->name }}</span>
                                    </a>
                                </div>
                                <div class="row align-items-center justify-content-between">
                                    <div class="col">
                                        {{-- share --}}
                                        <span class="color-gray me-2">
                                            <a href="javascript:;" id="share-discussions"> <small>Share</small> </a>
                                            <input type="text" value="{{ route('discussions.show', $discussion->slug) }}"
                                                id="current-url" class="d-none">
                                        </span>

                                        {{-- edit --}}
                                        {{-- kasih penjagaan jika bkn punya nya maka hilangkan tombol edit --}}
                                        @if ($discussion->user_id === auth()->id())
                                            {{-- edit --}}
                                            <span class="color-gray me-2">
                                                <a href="{{ route('discussions.edit', $discussion->slug) }}">
                                                    <small>Edit</small> </a>
                                            </span>

                                            {{-- delete --}}
                                            <form class="d-inline-block"
                                                action="{{ route('discussions.destroy', $discussion->slug) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="color-gray btn p-0 lh-1"
                                                    id="delete-discussion">
                                                    <small class="card-discussion-delete-btn">Delete</small>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="col-5 col-lg-3 d-flex">
                                        <a href="#"
                                            class="card-discussions-show-avatar-wrapper flex-shrink-0 rounded-circle overflow-hidden me-1">
                                            <img src="{{ filter_var($discussion->User->picture, FILTER_VALIDATE_URL) ? $discussion->User->picture : Storage::url($discussion->User->picture) }}"
                                                class="avatar" alt="avatar">
                                        </a>

                                        <div class="fs-12px lh-1">
                                            <span class="text-primary">
                                                <a href="#" class="fw-bold d-flex align-items-start text-break mb-1">
                                                    {{ $discussion->User->username }}
                                                </a>
                                            </span>
                                            <span class="color-gray">{{ $discussion->created_at->diffForHumans() }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        // ini perlu gw pelajari karena ribet
                        $answerCount = $discussion->answers->count();
                    @endphp

                    <h3 class="mb-5">{{ $answerCount . ' ' . Str::plural('Answer', $answerCount) }}</h3>

                    @forelse ($discussionAnswers as $answer)
                        <div class="mb-5">
                            <div class="card card-discussions">
                                <div class="row">
                                    <div class="col-1 d-flex flex-column justify-content-start align-items-center">
                                        <a href="javascript:;" data-id="{{ $answer->id }}"
                                            data-liked="{{ $answer->liked() }}" class="answer-like">
                                            <img src="{{ $answer->liked() ? $likedImage : $notLikedImage }}"
                                                class="answer-like-icon like-icon mb-1 d-block" alt="Like">
                                            <span
                                                class="fs-4 color-gray mb-1 answer-like-count ms-2">{{ $answer->likeCount }}
                                        </a>
                                        </span>
                                    </div>
                                    <div class="col-11">
                                        <div>
                                            {!! $answer->answers !!}
                                        </div>
                                        <div class="col">
                                            @if ($answer->user_id == auth()->id())
                                                {{-- edit --}}
                                                <span class="color-gray me-2">
                                                    <a href="{{ route('answers.edit', $answer->id) }}">
                                                        <small>Edit</small>
                                                    </a>
                                                </span>

                                                {{-- Delete --}}
                                                <form action="{{ route('answers.destroy', $answer->id) }}"
                                                    method="POST"class="d-inline-block lh-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="color-gray btn btn-link text-decoration-none p-0 lh-1 delete-answer">
                                                        <small>Delete</small>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="row align-items-end justify-content-end">
                                            <div class="col-5 col-lg-3 d-flex">
                                                <a href="#"
                                                    class="card-discussions-show-avatar-wrapper flex-shrink-0 rounded-circle overflow-hidden me-1">
                                                    {{-- yg masi bingung models answer pdhl tdk punya relasi belongsto ke user_id tp bisa berelasi --}}
                                                    <img src="{{ filter_var($answer->User->picture, FILTER_VALIDATE_URL) ? $answer->User->picture : Storage::url($answer->User->picture) }}"
                                                        class="avatar" alt="{{ $answer->User->username }}">
                                                </a>

                                                <div class="fs-12px lh-1">
                                                    <span
                                                        class="{{ $answer->User->username === $discussion->User->username ? 'text-primary' : '' }}">
                                                        <a href="#"
                                                            class="fw-bold d-flex align-items-start text-break mb-1">
                                                            {{ $answer->User->username }}
                                                        </a>
                                                    </span>
                                                    <span class="color-gray">4 hours ago</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="card">
                            <span>Not Discussion Yet</span>
                        </div>
                    @endforelse

                    {{ $discussionAnswers->links() }}

                    @auth
                        <h3>Your Answer</h3>
                        <div class="card">
                            <form action="{{ route('discussions.answer.store', $discussion->slug) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="answers" class="form-control @error('answers') is-invalid @enderror" id="answer"></textarea>
                                    @error('answers')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <div class="fw-bold text-center">
                            Please <a href="{{ route('auth.login.login') }}" class="text-primary">sign in</a> or <a
                                href="{{ route('auth.sign-up.sign-up') }}" class="text-primary">
                                create an account</a> to participate in this discussion
                        </div>
                    @endguest

                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <h3>All Categorie</h3>
                        <div>
                            @foreach ($categories as $category)
                                <a href="{{ route('discussions.categories.show', $category->slug) }}"> <span
                                        class="badge rounded-pill text-bg-light">{{ $category->name }}</span> </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('after-script')
    <script>
        $(document).ready(function() {
            $('#share-discussions').click(function() {
                var copyText = $('#current-url');

                copyText[0].select();
                copyText[0].setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.val());

                var alert = $('#alert');
                alert.removeClass('d-none');

                var alertContainer = alert.find('.container');
                alertContainer.first().text('Link to this discussions copied successfully');
            });

            // configurasi summernote
            $('#answer').summernote({
                placeholder: 'Write your solution here',
                tabSize: 2,
                height: 220,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview', 'help']]
                ]
            });
            $('span.note-icon-caret').remove();


            // login discussion like
            $('#discussion-like').click(function() {
                // utk like
                var isLiked = $(this).data('liked'); // ini utk ngambil data-liked
                var likeRoute = isLiked ? "{{ route('discussions.like.unlike', $discussion->slug) }}" :
                    "{{ route('discussions.like.like', $discussion->slug) }}";

                $.ajax({
                        method: 'POST',
                        url: likeRoute,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        }
                    })

                    .done(function(res) {
                        if (res.status === 'success') {
                            $('#discussion-like-count').text(res.data.likeCount);

                            if (isLiked) {
                                $('#discussion-like-icon').attr('src', '{{ $notLikedImage }}');
                            } else {
                                $('#discussion-like-icon').attr('src', '{{ $likedImage }}');
                            }
                            $('#discussion-like').data('liked', !isLiked);
                        }
                    })
            });

            // confirm apakah di hapus atau tidak
            $('#delete-discussion').click(function(event) {
                if (!confirm('Delete this Discussion')) {
                    // utk men stop submit form karena emg form itu ada default yang harus di stop
                    event.preventDefault();
                }
            })

            $('.delete-answer').click(function(event) {
                if (!confirm('Delete this Answer?')) {
                    // utk men stop submit form karena emg form itu ada default yang harus di stop
                    event.preventDefault();
                }
            })


            // login answer like berdasarkan id
            $('.answer-like').click(function() {
                var $this = $(this); // this berfungsi utk me bind kita ini mau merujuk ke this yang mana
                var id = $this.data('id');
                var isLiked = $this.data('liked');

                var likeRoute = isLiked ? '{{ url('') }}/answers/' + id + '/unlike' :
                    '{{ url('') }}/answers/' + id + '/like';


                $.ajax({
                        method: 'POST',
                        url: likeRoute,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        }
                    })

                    .done(function(res) {
                        if (res.status === 'success') {
                            $this.find('.answer-like-count').text(res.data.likeCount);

                            if (isLiked) {
                                $this.find('.answer-like-icon').attr('src', '{{ $notLikedImage }}');
                            } else {
                                $this.find('.answer-like-icon').attr('src', '{{ $likedImage }}');
                            }

                            $this.data('liked', !isLiked);
                        }
                    })
            });
        });
    </script>
@endsection
