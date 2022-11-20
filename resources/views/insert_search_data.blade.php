@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('addStatus'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('addStatus') }}
                        </div>
                    @endif
                <form action="{{ url('search/insert') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <h5 class="border-bottom">Add Search Data</h5>
                        <label for="search_keyword" class="form-label">search keyword</label>
                        <input type="text" class="form-control" name="search_keyword" id="search_keyword" required>
                        @error('search_keyword')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="search_result" class="form-label">Search Result</label>
                        <textarea class="form-control" name="search_result" id="search_result" required></textarea>
                        @error('search_result')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
