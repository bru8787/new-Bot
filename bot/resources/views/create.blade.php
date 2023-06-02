<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    @php
       
        function importData()
        { require 'data.php';
            foreach ($data as $item) {
                $person = \App\Models\Bot::updateOrCreate($item);
        
                $person->updateOrCreate(
                    ['name' => $item['name']], 
                    ['code' => $item['code']], 
                    ['timezone' => $item['timezone']], 
                    ['utc' => $item['utc']], 
                    ['mobilecode' => $item['mobilecode']]);
            }
        }
        
    @endphp

    <button class="btn btn-info" onclick="{{ importData();}}">import data to db</button>

    <div class="container">
        <h2>Form</h2>

        <form method="POST" action="{{ route('store') }}" autocomplete="on">
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
                    <label for="countries">Country:</label>
                    <select name="countries" id="countries"class="form-control">
                        @foreach ($country as $item)
                            <option id="countries" name="countries" class="form-control" placeholder="Select country">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{ $errors->has('sernder_id') ? 'has-error' : '' }}">
                    <label for="sender_id">Sender id:</label>
                    <input name="sender_id" id="sender_id" type="text" class="form-control">
                </div>
            </div>
            <div class="row h-full" >
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
