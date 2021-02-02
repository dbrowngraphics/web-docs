
<div id="scrollable-dropdown-menu" class="navbar-form navbar-right">
    <input type="text" class="typeahead" placeholder="Nodes" autocomplete="off">
</div>


@push('script')
<script>
$(function () {

    var nodes = {!! json_encode(Dashboard\Node::getNodeAndName(), JSON_HEX_APOS) !!},

        redirect = function(node) {

            node = node.split(' - ')[0];
            var parts = window.location.pathname.split('/');

            parts.splice(0, 3);

            window.location = '/nodes/' + node + '/' + parts.join('/');
        },

        updateNavLinks = function() {
            var path = window.location.pathname,
                root = path.split('/').splice(0, 3);

            $.each($('.nav-link'), function () {
                $(this).attr('href', root.join('/') + '/' + $(this).attr('href'));
            });
        };

    // https://github.com/bassjobsen/Bootstrap-3-Typeahead
    $('.typeahead').typeahead({
        source: nodes,
        items: 'all',
        minLength: 2,
        fitToElement: true,
        afterSelect: redirect
    });

    $('.typeahead').focus();

    updateNavLinks();

})
</script>

@endpush