@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>View Adverts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View Adverts List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <section class="section dashboard">
        <div class="row">
            <h1>Adverts List</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>image</th>
                        <th>title</th>
                        <th>description</th>
                        <th>endDate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($adverts as $advert)
                        <tr>
                            <td>{{ $advert->id }}</td>
                            <td><img src="{{ asset('advertImages/' . $advert->image) }}" alt="Advert Image"
                                    style="max-height: 50px; max-width: 80px"></td>
                            <td>{{ $advert->title }}</td>
                            <td>{{ $advert->description }}</td>
                            <td>{{ $advert->endDateTime }}</td>
                            <td>
                                <a href="{{ route('viewAdDetail', ['advertId' => $advert->id]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-pencil"
                                        aria-hidden="true"></i> Edit</a>
                                <a href="{{ route('showDeleteView', ['advertId' => $advert->id]) }}"
                                    class="btn btn btn-outline-danger btn-outline btn-sm" style="width: 6em;"><i
                                        class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            @if ($adverts->currentPage() > 1)
                <a href="{{ $adverts->previousPageUrl() }}">Previous</a>
            @endif

            @for ($i = max(1, $adverts->currentPage() - 2); $i <= min($adverts->lastPage(), $adverts->currentPage() + 2); $i++)
                <a href="{{ $adverts->url($i) }}"
                    class="{{ $i == $adverts->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor

            @if ($adverts->currentPage() < $adverts->lastPage())
                <a href="{{ $adverts->nextPageUrl() }}">Next</a>
            @endif
        </div>

    </section>
@endsection
