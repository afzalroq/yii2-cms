//byazam
let options = '', key, value
const
    self = 'self',
    titles = document.querySelectorAll('[data-type="titles"]'),
    helperForm = $('.field-menu-types_helper'),
    linkForm = $('.field-menu-link'),
    typeHelper = $('#menu-type_helper'),
    helper = $('#menu-types_helper'),
    types = $('#menu-types'),
    type = $('#menu-type'),
    link = $('#menu-link');

//region init

typeList.forEach((type) => options += '<option value=type_' + type[0] + '>' + type[1] + '</option>')
actionList.forEach((action) => options += '<option value=action_' + action[0] + '>' + action[1] + '</option>')
collectionList.forEach((collection) => options += '<option value=collection_' + collection.id + '>' + collection.name + '</option>')
optionList.forEach((option) => options += '<option value=option_' + option.id + '>' + option.name + '</option>')
entityList.forEach((entity) => options += '<option value=entity_' + entity.id + '>' + entity.name + '</option>')
types.html(options)

hideAll()
switch (Number(typeValue)) {
    case constEmpty:
    case constAction:
        types.val(typesValue)
        break
    case constLink:
        types.val(typesValue)
        linkForm.slideDown()
        break
    case constCollection:
    case constEntity:
    case constOption:
    case constItem:
    case constEntityItem:
        initCEOI()
        break
    default:
        types.val('type_' + constEmpty)
        type.val(constEmpty)
        typeHelper.val(null)
}
//endregion

//region bindings

link.on('change', function () {
    setNames(this.value)
    typeHelper.val(this.value)
})

helper.on('change', function () {
    let text = helper.find(":selected").text()
    let value = this.value
    let [id, _type] = value.split('_')

    if (_type) {
        initSelf(id, _type)
        return
    }

    if ((_type = localStorage.getItem('type')))
        type.val(_type)

    setNames(text)
    typeHelper.val(id)
})

types.on('change', function () {
    [key, value] = this.value.split('_')
    hideAll()

    switch (key) {
        case 'type':
            typeControl(Number(value));
            break
        case 'action':
            type.val(constAction)
            typeHelper.val(value)
            setNames(types.find(":selected").text())
            break
        case 'collection':
            type.val(constOption)
            postAjax(value, key)
            break
        case 'option':
            type.val(constItem)
            postAjax(value, key)
            break
        case 'entity':
            type.val(constEntityItem)
            postAjax(value, key)
            break
    }
})

//endregion

//region extra methods

function postAjax(id, type) {
    $.ajax(ajaxUrl, {
        data: {
            id: id,
            type: type
        },
        method: 'POST',
        success: function (data) {
            if (data.status && data.data.length !== 0) {
                options = '<option value=' + id + '_' + type + '>' + self + '</option>';
                data.data.forEach((item) => options += '<option value=' + item.id + '>' + item.name + '</option>')

                //init type_helper and names
                initSelf(id, type)

                helper.html(options)
                helperForm.slideDown()
            } else {
                typeHelper.val('')
                setNames('')
                helper.html('')
                helperForm.hide()
            }
        }
    })
}

function initSelf(id, _type) {
    setNames(self)
    typeHelper.val(id)
    localStorage.setItem('type', type.val())
    switch (_type) {
        case 'collection':
            type.val(constCollection)
            break
        case 'entity':
            type.val(constEntity)
            break
    }
}
// init Collection, Entity, Option, Item
function initCEOI() {
    types.val(typesValue)
    helperForm.slideDown()
    helper.html(helperValue)
}

function typeControl(_type) {
    type.val(_type)
    setNames('')
    typeHelper.val('')

    if (_type === constLink) {
        hideAll();
        linkForm.slideDown();
    }
}

function hideAll() {
    linkForm.hide();
    helperForm.hide();
}

function setNames(text) {
    for (title of titles) {
        title.value = text
    }
}

//endregion