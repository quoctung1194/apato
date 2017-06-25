<script type="text/javascript">
    $( document ).ready(function() {
        $('.pagination a').off('click').on('click', function () {
            if($(this).attr('href') == undefined || $(this).attr('href') == '') {
                return false;
            }

            //load user list
            $('#usersContainer').load($(this).attr('href'));
            return false;
        });

        initButtons();
    });

    function initButtons()
    {
        let container = $('#userTags');
        let userTable = $('#usersTable');

        // loop tag element in container
        container.find('.tag').each(function() {
            let userId = $(this).attr('user-id');

            let targetButton = userTable.find('button[user-id=' + userId + ']');
            // check is null
            if(targetButton.length > 0) { // change status into removing button
                targetButton.attr('status', 'remove');
                targetButton.html('@lang("main.remove")');
            }
        });
    }

    function editAction(ref)
    {
        let btn = $(ref);
        let container = $('#userTags');

        // change status button
        if(btn.attr('status') == 'add') {
            btn.attr('status', 'remove');

            // create tag
            let tag = $('<div class="tag btn" user-id="'+ btn.attr('user-id') +'">' + btn.attr('username') + '</div>');
            // change button text
            btn.html('@lang("main.remove")');
            container.append(tag);
        } else {
            btn.attr('status', 'add');
            // change button text
            btn.html('@lang("main.adding")');

            // find tag element in container
            container.find('.tag').each(function() {
                if($(this).attr('user-id') == btn.attr('user-id')) {
                    $(this).remove();
                }
            });
        }
    }
</script>

<table id="usersTable" class="table" style="width: 100%;">
    <thead>
        <tr>
            <th width="70%">@lang('main.username')</th>
            <th width="30%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    {{ $user->username }}
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn btn-default" username="{{ $user->username }}" user-id="{{ $user->id }}"
                        onclick="editAction(this)" status="add">
                        @lang('main.adding')
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
    <div class="pull-right" style="margin-right: 30px">
    {{ $users->links() }}
    </div>
</div>