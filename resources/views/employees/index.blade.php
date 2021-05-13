@extends('base')
@extends('layouts.app')

@section('main')

<div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
</div>

<div class="row">
<div class="col-sm-12">
    <h1 class="display-3">Employees</h1>    
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Full Name</td>
          <td>Company</td>
          <td>Email</td>
          <td>Phone</td>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
        @if(Auth::user()->role === 'admin' || Auth::user()->employee()->first()->company === $employee->company)
        <tr>
            <td>{{$employee->first_name}} {{$employee->last_name}}</td>
            <td>{{$employee->company}}</td>
            <td>{{$employee->email}}</td>
            <td>{{$employee->phone}}</td>
            <td>
                @if(Auth::user()->role === 'admin' || Auth::user()->email === $employee->email)
                <a href="{{ route('employees.edit', $employee->id)}}" class="btn btn-primary">Edit</a>
                @endif
            </td>
            <td>
                @if(Auth::user()->role === 'admin')

                <form action="{{ route('employees.destroy', $employee->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                </form>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
  </table>
  {{ $employees->links() }}	
  <div>
  @if(Auth::user()->role === 'admin')
  <a style="margin: 19px;" href="{{ route('employees.create')}}" class="btn btn-primary">New employee</a>
  @endif
</div>  

@endsection