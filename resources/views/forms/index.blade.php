@extends('layouts/master')
@include('nodes/navbar')
{{-- @include('forms.modal_file') --}}
@include('forms/modal_edit')

@section('content')

    <h3>{{ $node->node }} - {{ $node->node_name }}
        {{-- <a href="{!! route('nodes.forms.create', [$node->node]) !!}">+ Add Entry</a> --}}
        <button type="button" class="btn btn-primary" 
            style="margin-left: 10px; position: relative; top: -3px;"
            data-toggle="modal" data-target="#formModal" data-action="CREATE">
                <span class="glyphicon glyphicon-plus" title="Add Form to Web" aria-hidden="true"></span>&nbsp;&nbsp;ADD ENTRY
        </button>
        <button id="syncWithLiveBtn" type="button" class="btn btn-warning" style="position: relative; top: -3px;"
            data-toggle="modal" data-target="#fileModal" data-action="FILE"><span class="glyphicon glyphicon-refresh" title="SYNC WITH LIVE" aria-hidden="true"></span>&nbsp;&nbsp;SYNC WITH LIVE
        </button>

    </h3>

    <br />
    <div class="row">
        <div class="col-lg-12">
            <div id="key_inactive"></div><div style="float:left; margin-left: 10px;">Form is inactive.</div>
            <div id="key_not_exist" style="margin-left: 25px;"></div><div style="float:left; margin-left: 10px;">Form exist on the server, but no associated record.</div>
            <div id="key_no_file_server" style="margin-left: 25px;"></div><div style="float:left; margin-left: 10px;">Document doesn't exsist on the server.</div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Filename Here</th>
                        @if ($isGroupCode)
                            <th>Group</th>
                        @endif

                        <th>Begin Date</th>
                        <th>End Date</th>
                        <th>Category</th>
                        <th>Last Modified</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

                {{-- <tbody class="table-bordered"> --}}
                <tbody>
                @foreach ($articleCollection as $form)

                    @if ($form->db)
                        @if ($form->active)
                            @if ($form->file)
                                <tr>
                            @else
                                <tr class="no-file-server">
                            @endif
                        @else
                            <tr class="danger">
                        @endif
                    @else
                        <tr class="warning">
                    @endif

                        <td>{!! str_limit($form->title, 75) !!}</td>
                        {{-- <td><a href="{!! route('displayForm', ['node' => $node->node, 'id' => $form->id]) !!}" target="_blank">{!! str_limit($form->filename, 75) !!}</a></td> --}}

                        <td class="center">
                            <a href="{!! route('nodes.forms.show', ['node' => $node->node, 'id' => $form->id]) !!}" target="_blank">{!! str_limit($form->filename, 75) !!}</a>
                        </td>

                        @if ($isGroupCode)
                            <td>{!! $form->groupcd !!}</td>
                        @endif

                        <td class="center">{!! $form->beginDate !!}</td>
                        <td class="center">{!! $form->endDate !!}</td>
                        <td class="center category-dropdown">{!! $form->category !!}</td>
                        <td class="center">{!! $form->modified !!}</td>

                        <td style="width: 60px">
                            <button type="button" id="edit_{{ $form->id }}" class="btn btn-primary btn-xs edit-btn"
                                data-toggle     = "modal"
                                data-target     = "#formModal"
                                data-id         = "{{ $form->id }}"
                                data-title      = "{{ $form->title }}"
                                data-text       = "{{ $form->text }}"
                                data-link       = "{{ $form->filename }}"
                                data-content    = "{{ $form->content }}"
                                data-groupcd    = "{{ $form->groupcd }}"
                                data-active     = "{{ $form->active }}"
                                data-section    = "{{ $form->section }}"
                                data-category   = "{{ $form->category }}"
                                data-categoryId = "{{ $form->categoryId }}"
                                data-beginDate  = "{{ $form->beginDate }}"
                                data-endDate    = "{{ $form->endDate }}"
                                @if (!$form->db)
                                    data-action  = "EDITNEW">
                                @else
                                    data-action  = "EDIT">
                                @endif
                                <span class="glyphicon glyphicon-edit" title="EDIT" aria-hidden="true"></span>&nbsp;&nbsp;EDIT
                            </button>
                        </td>
                        <td style="width: 60px;">
                        @if ($form->db)
                            <input type="checkbox" class="toggle-switch"
                                <?php
                                if($form->active) {
                                    echo "checked";
                                } else {
                                    echo "";
                                } ?>

                            data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                data-id      = "{{ $form->id }}"
                                data-node    = "{{ $node->node }}",
                                data-title   = "{{ $form->title }}"
                                data-text    = "{{ $form->text }}"
                                data-link    = "{{ $form->filename }}"
                                data-content = "{{ $form->content }}"
                                data-groupcd = "{{ $form->groupcd }}"
                                data-active  = "{{ $form->active }}"
                                data-section = "{{ $form->section }}">
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection

@push('script')
<script>
    // Toggle between Active/Inactive
    $(function(){
        $('.toggle-switch').change(function() {
            var tr = $(this).closest("tr");
            var node = $(this).data('node');

            var url = "/nodes/" + node + "/forms/" + $(this).data('id');
            var data = {
                _token: '{!! csrf_token() !!}',
                _method: 'PATCH',
                node: node,
                group_cd: $(this).data('groupcd'),
                article_section: $(this).data('section'),
                article_active: ($(this).data('active')) ? 0 : 1,
                article_link: $(this).data('link'),
                article_text: $(this).data('text'),
                article_title: $(this).data('title'),
                article_content: $(this).data('content'),
            }

            var element = this;

            $.post(url, data)
                .done(function(){
                    $(tr).toggleClass("danger");

                    if ($(element).data('active') == 1) {
                        $(element).data('active', 0);
                    } else {
                        $(element).data('active', 1);
                    }

                });
        });

        var files = {!! json_encode($files) !!};

        // var categories = {!! json_encode($categories) !!};

        // categories.forEach(function(category, index) {
        //     console.log(category.category);
        // });

        //  Error to show if the Link name is blank
        var errorMsg = "<div class='alert alert-danger alert-dismissable'>";
            errorMsg += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            errorMsg += "<strong>Error syncing this group, please contact IT.</strong></div>";

        var successMsg = "<div class='alert alert-success alert-dismissable'>";
            successMsg += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            successMsg += "<strong>You've successfully synced this group!</strong></div>";

        $('#syncWithLiveBtn').click( function (){
                $.ajax({
                    type: 'POST',
                    url: '/syncNode',
                    data: { node : '{{ $node->node }}',
                            section : 'FORMS',
                            '_token' : '<?php echo csrf_token() ?>'
                        },
                    success: function (data) {
                    // var result lets us know if the sync happened or errored
                        if('Y' === data.result) {
                            $('#page-content-wrapper > .container-fluid').prepend(successMsg);
                        } else {
                            $('#page-content-wrapper > .container-fluid').prepend(errorMsg);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        $('#page-content-wrapper > .container-fluid').prepend(errorMsg);
                    }
                });
        });
    });
</script>
@endpush
