$('#confirmButton').click(function()
{
    var memberCount   = '';
    var totalEstimate = 0;
    var totalConsumed = oldConsumed;
    var totalLeft     = 0;
    var error         = false;
    $('select[name^=team]').each(function()
    {
        if($(this).val() == '') return;

        memberCount++;

        var $tr     = $(this).closest('tr');
        var account = $(this).find('option:selected').text();

        var estimate = parseFloat($tr.find('[name^=teamEstimate]').val());
        if(!isNaN(estimate)) totalEstimate += estimate;
        if(isNaN(estimate) || estimate == 0)
        {
              bootbox.alert(account + ' ' + estimateNotEmpty);
              error = true;
              return false;
        }

        var consumed = parseFloat($tr.find('[name^=teamConsumed]').val());
        if(!isNaN(consumed)) totalConsumed += consumed;

        var $left = $tr.find('[name^=teamLeft]');
        var left  = parseFloat($left.val());
        if(!isNaN(left)) totalLeft += left;
        if(!$left.prop('readonly') && (isNaN(left) || left == 0))
        {
              bootbox.alert(account + ' ' + leftNotEmpty);
              error = true;
              return false;
        }

        if(estimate == 0 || isNaN(estimate))
        {
            $(this).val('').trigger("chosen:updated");
            bootbox.alert(estimateNotEmpty);
            error = true;
            return false;
        }
    })

    if(error) return false;

    if(memberCount < 2)
    {
        bootbox.alert(teamMemberError);
        return false;
    }

    $('#left').val(totalLeft);
    updateAssignedTo();

    $('.close').click();
});

/**
 * Update assignedTo.
 *
 * @access public
 * @return void
 */
function updateAssignedTo()
{
    var html       = '';
    var multiple   = $('#multiple').prop('checked');
    var assignedTo = $('#assignedTo').val();
    if(multiple)
    {
        var isTeamMember = false;
        var mode         = $('#mode').val();
        $('select[name^=team]').each(function()
        {
            if($(this).find('option:selected').text() == '') return;
            if($(this).val() == currentUser) isTeamMember = true;

            var account  = $(this).find('option:selected').val();
            var realName = $(this).find('option:selected').text();
            var selected = account == assignedTo ? 'selected' : '';

            html += "<option value='" + account + "' title='" + realName + "'" + selected + ">" + realName + "</option>";
        });

        if(mode == 'multi' && isTeamMember && mode != 'linear')
        {
            $('[name=assignedTo]').removeAttr('disabled').trigger('chosen:updated');
        }
        else
        {
            $('[name=assignedTo]').attr('disabled', 'disabled').trigger('chosen:updated');
        }
    }
    else
    {
        for(key in members)
        {
            var selected = key == assignedTo ? 'selected' : '';
            html += "<option value='" + key + "' title='" + members[key] + "'" + selected + ">" + members[key] + "</option>";
        }
    }

    $('#assignedTo').html(html);
    if(multiple && mode == 'linear' && $('#modalTeam tr.member-doing').length == 0 && $('#modalTeam tr.member-wait').length >= 1) $('[name=assignedTo]').val($('#modalTeam tr.member-wait:first').find('select[name^=team]:first').val());
    $('#assignedTo').trigger('chosen:updated');
}
