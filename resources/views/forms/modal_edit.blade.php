<div id="formModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- {!! Form::model($article, ['method' => 'PATCH', 'route' => ['articles.update', $article->id]]) !!} --}}
            {{-- <form id="modal_update" method="POST" action="{!! route('nodes.' . $section . '.store', $node->node) !!}/" accept-charset="UTF-8" enctype="multipart/form-data"> --}}

            <form id="modal_update" method="POST" action="{!! route('saveNode') !!}" accept-charset="UTF-8" enctype="multipart/form-data">
                {!! csrf_field() !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! $node->node !!} - {!! $node->node_name !!} </h4>
            </div>

            <div class="modal-body">
                {{-- <div id="modal-error">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Danger!</strong> The link you typed already exist.
                </div> --}}

                <input id="modal_node" name="node" type="hidden" value="{!! $node->node !!}" />
                <input id="modal_section" name="article_section" type="hidden" value="{!! strtoupper($section) !!}" />
                <div class="row">
                    <div class="col-md-3">
                        <label>TITLE :</label>
                    </div>
                    <div class="col-md-8">
                        <input id="modal_title" class="highlight" name="article_title" type="text" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>LINK :</label>
                    </div>
                    <div class="col-md-8">
                        <input id="modal_link" class="highlight" name="article_link" type="text" value="" />
                    </div>
                    <div class="col-md-1">
                        <input type="file" name="getfile" id="getfile" class="inputfile"/>
                        <label id="labelFile" for="getfile">
                            <span id="btn" class="btn btn-default glyphicon glyphicon-file" title="Add a File" aria-hidden="true"></span>
                        </label>
                    </div>
                </div>
                <div class="row hide">
                    <div class="col-md-3">
                        <label>TEXT :</label>
                    </div>
                    <div class="col-md-8">
                        <input id="modal_text" name="article_text" type="text" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>GROUP CODE :</label>
                    </div>
                    <div class="col-md-8">
                        <input id="modal_groupcd" name="group_cd" type="text" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>CATEGORY :</label>
                    </div>
                    <div class="col-md-8">
                        <select id="modal_category" name="article_category">
                            <option value="hidden">--- Select A Category ---</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row hide">
                    <div class="col-md-3">
                        <label>CONTENT :</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="modal_content" name="article_content" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>BEGIN DATE :</label>
                    </div>
                    <div class="col-md-3">
                        <input id="modal_begindate" name="article_begindate" type="text" placeholder="mm/dd/yyyy" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>END DATE :</label>
                    </div>
                    <div class="col-md-3">
                        <input id="modal_enddate" name="article_enddate" type="text" placeholder="mm/dd/yyyy" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="modal_active">ACTIVE :</label>
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" id="modal_active" name="article_active" value="Y" checked />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-reset">Reset</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
            {{-- {!! Form::close() !!} --}}
            </form>
        </div>
    </div>
</div>

@push('script')

<script>

    $('#modal-error').hide();

    $('#modal_begindate').mask('00/00/0000', {
        selectOnFocus: true
    });

    $('#modal_enddate').mask('00/00/0000', {
        selectOnFocus: true
    });

    $('#formModal').on('shown.bs.modal', function(e) {
        var target  = $(e.relatedTarget),
            id      = target.data('id'),
            title   = target.data('title'),
            text    = target.data('text'),
            active  = target.data('active'),
            link    = target.data('link'),
            groupcd = target.data('groupcd'),
            content = target.data('content'),
            action  = target.data('action'),
            section = target.data('section'),
            category = target.data('categoryid'),
            begin_date = target.data('begindate'),
            end_date = target.data('enddate'),
            columns = [];

        var type_selection = $('ul.nav li.active').text();
        // var url_action = '' + $('#modal_update').attr('action');
        var url_action = '{!! route('nodes.forms.store', $node->node) !!}';
        $('#formModal').find('#patch').remove();

        console.log('Action: ' + action);

        if ($('input#modal_link').attr("disabled") == 'disabled') {
            $('input#modal_link').removeClass('disabled').addClass('highlight');
            $('input#modal_link').removeAttr("disabled");
            $('label#labelFile #btn').removeAttr("disabled");
        }

        if ("CREATE" == action){
            // var thisURL = '{!! route('nodes.forms.store', $node->node) !!}';
            $('#modal_update').attr('action', url_action);

            console.log("Action: " + url_action);
            console.log("URL:  " + thisURL);

            // $('#formModal').find('#patch').remove();
            $('#formModal').find('#modal_section').val(type_selection);
            $('#formModal').find('#modal_active').prop('checked', 'checked');

            console.log("Inside Create");

        } else if ("EDITNEW" == action) {
            console.log("Edit as New");

            $('#modal_update').attr('action', url_action);
            $('input#modal_link').attr("disabled", "disabled");
            $('input#modal_link').removeClass('highlight').addClass('disabled');
            $('label#labelFile #btn').attr("disabled", "disabled");

        } else {
        // action  == EDIT
            console.log("In Edit -> Action: " + url_action);
            var thisURL = '{!! route('nodes.forms.index', $node->node) !!}' + '/' + id;

            $('#modal_update').attr('action', url_action + '/' + id );
            console.log("URL:  " + thisURL);
            console.log("Category number: " + category);

            var patch = '<input id="patch" name="_method" type="hidden" value="PATCH">';
            $('#modal_update').append(patch);
            $('#formModal').find('#modal_section').val(section);

            // $('#formModal').find('#modal_category option[value='+ category + ']').attr('selected', 'selected');
            $('#formModal').find('#modal_category').val(category);

            if(active) {
                $('#formModal').find('#modal_active').prop('checked', true);
            } else {
                $('#formModal').find('#modal_active').prop('checked', false);
            }
        }

        $('#formModal').find('.btn-reset').attr('id', 'reset_'+id);
        $('#formModal').find('#modal_title').val(title);
        $('#formModal').find('#modal_text').val(text);
        $('#formModal').find('#modal_link').val(link);
        $('#formModal').find('#modal_groupcd').val(groupcd);
        $('#formModal').find('#modal_content').val(content);
        $('#formModal').find('#modal_begindate').val(begin_date);
        $('#formModal').find('#modal_enddate').val(end_date);
    });

    $('#formModal').on('hidden.bs.modal', function(e) {
        $('#formModal').find('#modal_title').val("");
        $('#formModal').find('#modal_text').val("");
        $('#formModal').find('#modal_link').val("");
        $('#formModal').find('#modal_groupcd').val("");
        $('#formModal').find('#modal_content').val("");
        $('#formModal').find('#getfile').val("");
        $('#modal_link').attr('placeholder', '');
        $('#formModal').find('#modal_category').val('');
        // var url_action = '' + $('#modal_update').attr('action');
        // var reset_url = url_action.substring(0, url_action.lastIndexOf("/") + 1);
        // $('#modal_update').attr('action', reset_url);
    });

    $('#formModal .btn-reset').click( function(){

        var id = ($(this).attr("id")).substr(6),
            edit_btn = $("#edit_" + id);

        var title     = edit_btn.data('title'),
            text      = edit_btn.data('text'),
            link      = edit_btn.data('link'),
            groupcd   = edit_btn.data('groupcd'),
            content   = edit_btn.data('content'),
            category  = edit_btn.data('categoryid');

        $('#formModal').find('#modal_title').val(title);
        $('#formModal').find('#modal_text').val(text);
        $('#formModal').find('#modal_link').val(link);
        $('#formModal').find('#modal_groupcd').val(groupcd);
        $('#formModal').find('#modal_content').val(content);
        $('#formModal').find('#getfile').val('');
        $('#modal_link').attr('placeholder', '');
        // $('#formModal').find('#modal_category option[value=5]').attr('selected', 'selected');
        $('#formModal').find('#modal_category').val(category);
    });

    $('#getfile').on('change', function(e){
        let filename = this.files[0].name;
        let regex = /[^a-zA-Z0-9\-\_]+/gm;
        let lastPeriod = filename.lastIndexOf(".");
        let extention = filename.substring(lastPeriod, filename.length);
        let modFilename = filename.substring(0, lastPeriod);
        let removeCommas = modFilename.replace(/,/g, "");
        let modifiedFilename = removeCommas.replace(/ /g, "_");
        let regexFilename = modifiedFilename.replace( regex, '') + extention.toLowerCase();

        $('#modal_link').attr('placeholder', regexFilename);
        $('#modal_link').val(regexFilename);
    });

    $('button[type="submit"]').click( function(e){

        console.log('Submit Button Clicked');

        $('div#error_link').remove();
        $('div#error_blank').remove();
        $('div#error_pdf').remove();
        $('div#error_title').remove();

        var error = false;

        //  Error to show if the Title is blank
        var titleDiv = "<div id='error_title'class='alert alert-danger alert-dismissable'>";
            titleDiv += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            titleDiv += "<strong>Enter a title.</strong></div>";

        //  Error to show if the Link name already exist
        var linkDiv = "<div id='error_link' class='alert alert-danger alert-dismissable'>";
            linkDiv += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            linkDiv += "<strong>The link name already exist.</strong></div>";

        //  Error to show if the Link name is blank
        var blankLink = "<div id='error_blank' class='alert alert-danger alert-dismissable'>";
            blankLink += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            blankLink += "<strong>The Link field cannot be blank.</strong></div>";

        //  Error to show if Link is not a PDF
        var pdfLink = "<div id='error_pdf' class='alert alert-danger alert-dismissable'>";
            pdfLink += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>";
            pdfLink += "<strong>The Link must be a PDF.</strong></div>";

        var linkVal = $('#modal_link').val();

        // <?php
        // if (isset($files)) {
        // ?>
        //     var num = $.inArray($('#formModal').find('#modal_link').val(), {!! json_encode($files) !!});
        //     // num = -1;

        //     // Error: Link value already exists and the Link field is not disabled.
        //     // If the link field is disabled then this is an EDIT for a file that is on the server
        //     // but not in the database.
        //     if (num != -1 && $('input#modal_link').attr("disabled") != 'disabled') {

        //         e.preventDefault();
        //         $('.modal-body').prepend(linkDiv);
        //         $('#error_link').delay(1000).fadeOut(8000, function(){
        //             // console.log("fade out complete");
        //             $('div#error_link').remove();
        //         });

        //         error = true;

        //     } else {
        //         // Error: Link value must be a PDF
        //         if ('pdf' != linkVal.substring(linkVal.length - 3)){
        //             e.preventDefault();
        //             $('.modal-body').prepend(pdfLink);
        //             $('#error_pdf').delay(1000).fadeOut(8000, function(){
        //                 $('div#error_pdf').remove();
        //             });

        //             error = true;
        //         }
        //     }
        // <?php
        // }
        // ?>

        // Error: Link value must be a PDF
        var ext = linkVal.substring(linkVal.length - 3);
        if (('pdf' != ext) && ('PDF' != ext)){
            e.preventDefault();
            $('.modal-body').prepend(pdfLink);
            $('#error_pdf').delay(1000).fadeOut(8000, function(){
                $('div#error_pdf').remove();
            });

            error = true;
        }

        // Error: Blank Link value
        if ("" == linkVal){
            e.preventDefault();
            $('.modal-body').prepend(blankLink);
            $('#error_blank').delay(1000).fadeOut(8000, function(){
                $('div#error_blank').remove();
            });

            error = true;
        }

        // Error: Blank Title value
        if ( "" == $('#modal_title').val()){
            e.preventDefault();
            $('.modal-body').prepend(titleDiv);
            $('#error_title').delay(1000).fadeOut(8000, function(){
                $('div#error_title').remove();
            });

            error = true;
        }

        if ($('input#modal_link').attr("disabled") == 'disabled' && error == false) {
            $('input#modal_link').removeClass('disabled').addClass('highlight');
            $('input#modal_link').removeAttr("disabled");
        }

    });

    // $('#formModal').drags();
    $('#formModal').draggable();
</script>

@endpush