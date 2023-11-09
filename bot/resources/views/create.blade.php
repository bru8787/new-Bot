@extends('layouts.app')


@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
                    <div class="position-relative col-3 py-2 px-4 text-bg-success border border-secondary rounded-pill">
                        <strong class="aler alert-success">{{ $message }}</strong> <svg width="1em" height="1em"
                            viewBox="0 0 16 16" class="position-absolute top-100 start-50 translate-middle mt-1"
                            fill="var(--bs-secondary)" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="position-relative col-6 py-2 px-4 text-bg-danger border border-secondary rounded-pill">
                        <strong class="aler alert-danger">{{ $message }}</strong> <svg width="1em" height="1em"
                            viewBox="0 0 16 16" class="position-absolute top-100 start-50 translate-middle mt-1"
                            fill="var(--bs-secondary)" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>
                    </div>
                @endif
        {{-- <button id='importButton'  class='btn btn-info' type='button' onclick=window.location="{{ route('importData') }}">import</button> --}}
        <h2>Form</h2>
        <form method="POST" action="{{ route('store') }}" autocomplete="on" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (count($errors))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <br />
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row col-md-6">
                <div class="form-group">
                    <label for="countries">Country:</label>
                    <input required  class="form-control" list="browsers" id="countries" name="countries">
                    <datalist id="browsers">
                        @foreach ($country as $item)
                            <option class="form-control" value="{{ $item->name }}">
                                </option>
                        @endforeach
                    </datalist>

                </div>
                <div class="form-group ">
                    <label for="sender_id">Sender id:</label>
                    <input name="sender_id" required id="sender_id" type="text" class="form-control" value="">
                </div>
            </div>
            <div class="row h-full">
                <div class="col-md-6 h-full">
                    <div class="form-group ">
                        <label for="message">Text:</label>
                        <textarea required name="message" id="message" class="form-control" @style('height:200px') placeholder="Enter message"></textarea>
                        <span class="text-danger">{{ $errors->first('message') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn mt-3 btn-success">Submit</button>
            </div>
        </form>

    </div>
@endsection
