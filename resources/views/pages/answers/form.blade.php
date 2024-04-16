@extends('layout.app')

@section('title', 'Laracuss - Create')

@section('body')
    <section class="bg-gray pt-4 pb-5">
        <div class="container">
            <div class="mb-5">
                <div class="d-flex align-items-center">
                    <div class="d-flex">
                        <div class="fs-2 fw-bold me-2 mb-0">
                            Answer a Question
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8 mb-lg-0">
                    <div class="card card-discussions mb-5">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('answers.update', $answer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="answers" class="form-label">Content</label>
                                        <textarea class="form-control @error('answers') is-invalid @enderror" name="answers" id="answer" autofocus>{{ $answer->answers ?? old('answers') }}</textarea>
                                        @error('answers')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                                        {{-- ke show berdasarkan slug --}}
                                        <a href="{{ route('discussions.show', $answer->discussion->slug) }}">Cancel</a>
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
            $('#answer').summernote({
                placeholder: 'Your solution....',
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
