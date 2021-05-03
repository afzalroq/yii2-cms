$('#collectionsId').on('change', function () {
    value = this.value;
    let options = '';
    const optionDropdown = $('#cam-option_id')
    $.ajax({
        url: 'options-list',
        method: "GET",
        data: {
            'collectionId': value,
            'menuType': $('#menuType').val()
        },
        dataType: "json",
        type: 'get',
        success: function (response) {
            if (response.status) {
                response.data.forEach((option) => options += '<option value=' + option.id + '>' + option.name + '</option>')
                optionDropdown.html(options)
            }
        }
    })
})