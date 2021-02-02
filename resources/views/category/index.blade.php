@extends('layouts/master')

@section('content')

<select required>

<option value="" hidden>Example Placeholder</option>

@foreach ($categories as $cat)
    <option value="{{ $cat->id }}">{{ $cat->category }}</option>
@endforeach

</select>

@endsection