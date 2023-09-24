<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    @vite('resources/js/app.js')

</head>

<body>
    <button class='btn btn-info' type='button' onclick=window.location="{{ route('importData') }}">import</button>
    <div class="container">
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
                <div class="form-group {{ $errors->has('countries') ? 'has-error' : '' }}">
                    <label for="countries-select">Country:</label>
                    <select name="countries-select" id="countries-select"class="form-control " >
                        <option value="" disabled selected >Select country</option>
                        @foreach ($country as $item)
                            <option id="countries" name="countries" class="form-control" value={{
                            old('$item->id') }}
                               > {{ old('$item->name' )}} </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group {{ $errors->has('sernder_id') ? 'has-error' : '' }}">
                    <label for="sender_id">Sender id:</label>
                    <input name="sender_id" id="sender_id" type="text" class="form-control">
                </div>
            </div>
            <div class="row h-full">
                <div class="col-md-6 h-full">
                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        <label for="message">Text:</label>
                        <textarea name="message" id="message" class="form-control "@style('height:100px') placeholder="Enter message">{{ old('message') }}</textarea>
                        <span class="text-danger">{{ $errors->first('message') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>
