@extends('layout.app')

@section('title', 'Halaman Home')
@section('body')
    {{-- hero section --}}
    <section class="container hero">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <h1>The Laravel <br> Comunity Forum</h1>
                <p class="mb-4">Empowering the Laravel Comunity to connect, share and learn</p>
                <div>
                    <a href="{{ route('auth.sign-up.show') }}" class="btn btn-primary mb-2 me-2 mb-lg-0">Sign Up</a>
                    <a href="{{ route('discussions.index') }}" class="btn btn-secondary mb-2 mb-lg-0">Join Discussion</a>
                </div>
            </div>
            {{-- keren order first order-lg-last --}}
            <div class="col-12 col-lg-6 text-center  order-first order-lg-last mb-3 mb-lg-0">
                <img class="hero-image float-lg-end" src="{{ asset('assets/images/bg-hero.png') }}" alt="">
            </div>
        </div>
    </section>
    {{-- end hero section --}}


    {{-- population --}}
    <section class="container min-h-372px">
        <div class="row">
            <div class="col-12 col-lg-4 text-center">
                <img class="promote-icon mb-2" src="{{ asset('assets/images/discussions.png') }}" alt="Discussion">
                <h2>{{ Str::plural('Discussion', $discussionCount) }}</h2>
                <p class="fs-3">{{ $discussionCount }}</p>
            </div>

            <div class="col-12 col-lg-4 text-center">
                <img class="promote-icon mb-2" src="{{ asset('assets/images/answers.png') }}" alt="Answer">
                <h2>{{ Str::plural('Answer', $answerCount) }}</h2>
                <p class="fs-3">{{ $answerCount }}</p>
            </div>

            <div class="col-12 col-lg-4 text-center">
                <img class="promote-icon mb-2" src="{{ asset('assets/images/users.png') }}" alt="Users">
                <h2>{{ Str::plural('User', $userCount) }}</h2>
                <p class="fs-3">{{ $userCount }}</p>
            </div>
        </div>
    </section>
    {{-- end popular --}}

    {{-- help others --}}
    <section class="container-fluid bg-gray">
        <div class="container py-80px">
            <h2 class="text-center mb-5">Help Others</h2>
            <div class="row">

                @forelse($latestDiscussion as $latestDiscussion)
                    <div class="col-12 col-lg-4 mb-3">
                        <div class="card">
                            <a href="{{ route('discussions.show', $latestDiscussion->slug) }}">
                                <h3>{{ $latestDiscussion->title }}</h3>
                            </a>
                            <div>
                                <p class="mb-5">
                                    {!! $latestDiscussion->content_preview !!}
                                </p>
                                <div class="row">
                                    <div class="col me-1 me-lg-2">
                                        <a
                                            href="{{ route('discussions.categories.show', $latestDiscussion->Category->slug) }}">
                                            <span
                                                class="badge rounded-pill text-bg-light">{{ $latestDiscussion->Category->name }}</span>
                                        </a>
                                    </div>
                                    <div class="col-5 col-lg-7">
                                        <div class="avatar-sm-wrapper d-inline-block">
                                            <a href="#" class="me-1">
                                                <img src="{{ filter_var($latestDiscussion->User->picture, FILTER_VALIDATE_URL) ? $latestDiscussion->User->picture : Storage::url($latestDiscussion->User->picture) }}"
                                                    class="avatar rounded-circle" alt="Avatar">
                                            </a>
                                        </div>
                                        <span class="fs-12px">
                                            <a href="{{ route('users.show', $latestDiscussion->User->username) }}"
                                                class="me-1 fw-bold">
                                                {{ Str::limit(strip_tags($latestDiscussion->User->username), 7, '...') }}
                                            </a>
                                            <span
                                                class="color-gray">{{ $latestDiscussion->created_at->diffForHumans() }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
    </section>
    {{-- end help others --}}

    {{-- call to action --}}
    <section class="container">
        <div class="min-h-372px d-flex flex-column align-items-center justify-content-center">
            <h2>Ready to contribute?</h2>
            <p class="mb-4">Wan to make a big impact?</p>
            <div class="text-center">
                <a href="{{ route('auth.sign-up.show') }}" class="btn btn-primary me-2 mb-2 mb-lg-0">Sign Up</a>
                <a href="{{ route('discussions.index') }}" class="btn btn-secondary mb-2 mb-lg-0">Join Discussions</a>
            </div>
        </div>
    </section>

    {{-- end call to action --}}
@endsection
