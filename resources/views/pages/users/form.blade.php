@extends('layout.app')

@section('title', 'Halaman - Profile saya')

@section('body')
    <section class="bg-gray pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5 ">
                    <form action="{{ route('users.update', $user->username) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-column flex-md-row mb-4">
                            <div class="edit-avatar-wrapper mb-3 mb-md-0 mx-auto mx-md-0">
                                <div class="avatar-wrapper rounded-circle overflow-hidden flex-shrink-0 me-4">
                                    <img id="avatar" src="{{ $picture }}" alt="avatar" class="avatar">
                                </div>
                                <label for="picture" class="btn p-0 edit-avatar-show">
                                    <img src="{{ asset('assets/images/edit-circle.png') }}" alt="">
                                </label>
                                <input type="file" class="d-none" name="picture" id="picture" accept="image/*">
                            </div>

                            <div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" id="username" value="{{ old('username', $user->username) }}"
                                        autofocus>
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password">
                                    <div class="fs-12px color-gray">
                                        kosongkan ini jika Anda tidak ingin mengubah kata sandi Anda
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="confirm-password" class="form-label">Confir Password</label>
                                    <input type="password"
                                        class="form-control @error('confirm-password') is-invalid @enderror"
                                        name="confirm-password" id="confirm-password">
                                    <div class="fs-12px color-gray">
                                        kosongkan ini jika Anda tidak ingin mengubah kata sandi Anda
                                    </div>
                                    @error('confirm-password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary me-4">Save</button>
                            <a href="{{ route('users.show', $user->username) }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('after-script')
    <script>
        $('#picture').on('change', function(event) {
            var output = $('#avatar');
            output.attr('src', URL.createObjectURL(event.target.files[0]));
            output.onload = function() {
                URL.revokeObjectURL(output.attr);
            }
        })
    </script>
@endsection
