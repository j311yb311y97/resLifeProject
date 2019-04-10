@extends('layouts.layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Gender</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($genders as $gender)
        <tr>
            <td>{{$gender->id}}</td>
            <td>{{$gender->Gender}}</td>
            <td><a href="{{ route('genders.edit',$gender->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('genders.destroy', $gender->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection