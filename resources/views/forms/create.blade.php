@extends('layouts/master')
@include('nodes/navbar')


@section('content')
<h3>{{ $node->node }} - {{ $node->node_name }}</h3>
<div class="col-lg-10">
    <h2>Create A New Form Entry</h2>
    <form method="POST" action="{!! route('nodes.forms.store', [$node->node]) !!}/" accept-charset="UTF-8" style="">
        {!! csrf_field() !!}
        <div class="ui form">
            {!! Form::hidden('node', $node->node) !!}
            {!! Form::hidden('node_action', 'FORMS') !!}
            <div class="fields">
                {{-- <div class="field">
                    <label>Pick A Node:</label>
                    {{ Form::select('node_id', $node_list, null, ['class' => 'ui dropdown search selection']) }}
                </div> --}}
                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" />
                </div>
                <div class="field">
                    <label>Link to Resource</label>
                    <input type="text" name="link" />
                </div>
                <div class="field">
                    <label>Group Code</label>
                    <input type="text" name="group_cd" />
                </div>
                <div class="field">
                        <label for="">&nbsp;</label>
                        <button class="ui right floated primary button" name="submit" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="col-lg-2">
    <h4 style="text-align: left;">CURRENT FILE LIST</h4>
    <ul id="file_list" class="striped-list">
    @foreach ($files as $file)
        <li>{!! $file !!}</li>
    @endforeach
    </ul>
</div>

@endsection