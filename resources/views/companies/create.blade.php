@extends('base')
@extends('layouts.app')
@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Add a company</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('companies.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">    
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="text" class="form-control" name="email">
          </div>

          <div class="form-group">
              <label for="logo">Logo:</label>
              <input id="logo" type="file" class="form-control" name="logo">
          </div>

          <div class="form-group">
              <label for="website">Website:</label>
              <input type="text" class="form-control" name="website"/>
          </div>

          <button type="submit" class="btn btn-primary">Add company</button>
      </form>
  </div>
</div>
</div>
@endsection