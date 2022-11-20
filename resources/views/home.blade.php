@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <!-- Job Category Listing start -->
                <div class="job-category-listing mb-50">
                    <!-- single one -->
                    <div class="single-listing">
                        <!-- select-Categories start -->
                        <div class="select-Categories pb-50">
                            <div class="small-section-tittle2">
                                <h4>Search Keywords</h4>
                            </div>
                            @foreach ($search_histories as $history)
                                <label class="container">{{ $history->search_keyword }} ({{ $history->hits }}
                                    times found)
                                    <input type="checkbox" id="keyword{{ $history->id }}"
                                        onclick="loadData({{ $history->id }})">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach

                        </div>
                        <!-- select-Categories End -->
                    </div>
                    <!-- single two -->

                    <div class="single-listing">
                        <!-- Select job items start -->
                        <div class="select-Categories pb-50">
                            <div class="small-section-tittle2">
                                <h4>Select Date:
                                </h4>
                            </div>
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" onchange="loadDataByDate()" name="start_date"
                                class="form-control" placeholder="Start date">

                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" onchange="loadDataByDate()" name="end_date"
                                class="form-control" placeholder="End date">

                        </div>
                    </div>
                </div>
                <!-- Job Category Listing End -->
            </div>
            <div class="col-lg-9">
                <form action="{{ url('/') }}" method="get">
                    @csrf
                    <div class="row m-0 justify-content-center align-items-center">
                        <div class="col-10">
                            <input type="text" name="query" class="form-control bg-white py-3 px-4 fs-5"
                                style="border-radius: 35px;" value="{{ isset($_GET['query']) ? $_GET['query'] : '' }}"
                                placeholder="Search.." />
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </div>

                </form>

                <div class="row">
                    <div class="col-lg-10">
                        <div class="py-5" style="text-align: justify;" id="search_result">
                            @if (session('status'))
                                <div class="alert alert-danger mt-3" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @foreach ($search_result as $result)
                                <p class="border-top p-2">
                                <h6>{{ $result->hits }} times found.</h6>
                                {{ $result->search_result }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <h3 id="title"></h3>
    <script type=text/javascript>
        let idArr = [];

        function loadData(history_id) {
            let checkbox = document.getElementById(`keyword${history_id}`).checked;

            if (checkbox) {
                let newArr = idArr.filter(id => id != history_id);
                idArr = [...newArr];
                idArr.push(history_id);
            } else {
                let newArr = idArr.filter(id => id != history_id);
                idArr = [...newArr];
            }

            let idString = idArr.toString();

            let resultContainer = document.getElementById("search_result");
            idString.length > 0 ?
                fetch(`search/${idString}`)
                .then(res => res.json())
                .then(data => {
                    let div = '';
                    for (let i = 0; i < data.length; i++) {
                        div +=
                            `<p class="border-top p-2"><h6>${data[i].hits} times found.</h6>${data[i].search_result}</p>`;
                    }
                    resultContainer.innerHTML = div;
                }) :
                resultContainer.innerHTML = '';
        }

        function loadDataByDate() {
            let start_date = document.getElementById('start_date').value;
            let end_date = document.getElementById('end_date').value;

            let resultContainer = document.getElementById("search_result");
            start_date.length > 0 ?
                fetch(`search-by-date/?start_date=${start_date}&end_date=${end_date}`)
                .then(res => res.json())
                .then(data => {
                    // console.log(data);
                    let div = '';
                    for (let i = 0; i < data.length; i++) {
                        div +=
                            `<p class="border-top p-2"><h6>${new Date(data[i].created_at)}</h6>${data[i].search_result}</p>`;
                    }
                    resultContainer.innerHTML = div;
                }) :
                resultContainer.innerHTML = '';
        }
    </script>
@endsection
