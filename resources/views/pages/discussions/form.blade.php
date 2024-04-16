@extends('layout.app')

@section('title', 'Laracuss - Create')

@section('body')
    <section class="bg-gray pt-4 pb-5">
        <div class="container">
            <div class="mb-5">
                <div class="d-flex align-items-center">
                    <div class="d-flex">
                        <div class="fs-2 fw-bold me-2 mb-0">
                            Ask a Question
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8 mb-lg-0">
                    <div class="card card-discussions mb-5">
                        <div class="row">
                            <div class="col-12">
                                {{-- jika ada $discussion mk routenya jadi route('discussions.update', $discussion->slug) --}}
                                <form
                                    action="{{ isset($discussion) ? route('discussions.update', $discussion->slug) : route('discussions.store') }}"
                                    method="POST">
                                    @csrf
                                    @if (isset($discussion))
                                        @method('PUT')
                                    @endif

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror" type="text"
                                            name="title" id="title" value="{{ $discussion->title ?? old('title') }}"
                                            autofocus>
                                        {{-- discussion title kalo tdk ada maka ya  old title aja --}}
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_slug" class="form-label">Category</label>
                                        <select class="form-select @error('category_slug') is-invalid @enderror"
                                            name="category_slug" id="category_slug">
                                            <option value="" hidden>-- Choose One --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->slug }}"
                                                    @if (($discussion->Category->slug ?? old('category_slug')) === $category->slug) {{ 'selected' }} @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Question</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content">{{ $discussion->content ?? old('content') }}</textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                                        <a href="{{ route('discussions.index') }}">Cancel</a>
                                    </div>
                                </form>
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
            $('#content').summernote({
                placeholder: 'The details of your problem | What did you try | What you were expecting',
                tabSize: 2,
                height: 320,
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

        });
    </script>
@endsection
