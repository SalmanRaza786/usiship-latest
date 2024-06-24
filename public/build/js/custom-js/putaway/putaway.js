$(document).ready(function() {
    $('.btn-add-row').on('click', function() {

        var clonedRow = $('#clonedSection tr:first').clone();

        clonedRow.find('input').val('');
        clonedRow.find('select').val('');


        $('#clonedSection').append(clonedRow);
        updateRowNumbers();
    });

    function updateRowNumbers() {
        $('#clonedSection tr').each(function(index) {
            $(this).find('th').text(index + 1);
        });
    }

    $('#clonedSection').on('click', '.delete-row', function() {

        var rowIndex = $(this).closest('tr').index();
        if (rowIndex > 0) {
            $(this).closest('tr').remove();
        }
    });
});
