@extends('layouts/master')
@include('nodes/navbar')

@section('content')

    <h3>{{ $node->node }} - {{ $node->node_name }}</h3>
    <div class="col-lg-10">
    {!! Form::model($form, ['method' => 'PATCH', 'route' => ['nodes.forms.update', $node->node, $form->id]]) !!}
        <div class="fields">
            {!! Form::hidden('node', $node->node) !!}
            {!! Form::hidden('article_section', $form->article_section) !!}
            {!! Form::hidden('article_text', $form->article_text) !!}
            {!! Form::hidden('article_content', $form->article_content) !!}
            {!! Form::hidden('active_yn', $form->active_yn) !!}

            <div class="required field">
                {!! Form::label('article_title', 'Title:') !!}
                {!! Form::text('article_title', $form->article_title, ['class' => '']) !!}
            </div>
            <div class="required field">
                {!! Form::label('article_link', 'Link:') !!}
                {!! Form::text('article_link', $form->article_link, ['class' => '']) !!}
            </div>
{{--             <div class="required field">
                {!! Form::label('article_text', 'Article Text:') !!}
                {!! Form::text('article_text', $form->article_text, ['class' => '']) !!}
            </div> --}}
{{--             <div class="required field">
                {!! Form::label('article_content', 'Article Content:') !!}
                {!! Form::text('article_content', $form->article_content, ['class' => '']) !!}
            </div> --}}
{{--             <div class="required field">
                {!! Form::label('article_section', 'Article Section:') !!}
                {!! Form::text('article_section', $form->article_section, ['class' => '']) !!}
            </div> --}}
            <div class="required field">
                {!! Form::label('group_cd', 'Group Code:') !!}
                {!! Form::text('group_cd', $form->group_cd, ['class' => '']) !!}
            </div>
{{--             <div class="ui checkbox">
                {!! Form::checkbox('active_yn', $form->active_yn, true, ['class' => '']) !!}
                {!! Form::label('active_yn', 'Active?') !!}
            </div>
--}}
            <div class="field">
                {!! Form::label('', '&nbsp;') !!}
                {!! Form::submit('UPDATE', ['class' => '']) !!}
            </div>
        </div>
    {!! Form::close() !!}

    <p>{!! strtoupper(date('d-M-Y', strtotime($form->begin_date))) !!}</p>

    </div>

    <div class="col-lg-2">
        <h4 style="text-align: center;">CURRENT FILE LIST</h4>
        <ul id="file_list" class="striped-list">
        @foreach ($files as $file)
            <li>{!! $file !!}</li>
        @endforeach
        </ul>
    </div>
@endsection