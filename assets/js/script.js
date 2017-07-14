jQuery(document).ready(function(){
    var startX=0;
    var depth=50;
    var maxDeptch;
    var classBootstrap;
    var prev;
    var offsets=$('#menu-to-edit').offset();
    $(".sortable-ui").sortable({
        grid:[50,50],
        //items:"li:not(.ui-state-disabled)",
        connectWith:".connectedSortables",
        start: function (event, ui) {
            startX = event.clientX;
            ui.item.removeClass(classBootstrap);
        },
        beforeStop: function(event, ui){
            devision = Math.round((ui.offset.left - offsets.left) / depth);

        },
        stop: function (event, ui) {
            id=ui.item.prev().index();
            ui.item.prev().attr('data-id',id);
            var classDeptch = 1;
            startX = event.clientX;
            prev = ui.item.prev().attr('data-depth')
            maxDeptch = parseInt(prev) + 1;
            var extId=ui.item.parents('ul').attr('data-class');
            if (devision >= maxDeptch) {
                classDeptch = maxDeptch;
            } else {
                classDeptch = devision;
            }
            if(classDeptch>0){
                var siblingItemDepht = Number(classDeptch)-Number(1);
                var parent = ui.item.prevAll('[data-depth=' + siblingItemDepht + ']').first();
                var index= parent.index();
                var sibling=ui.item.siblings();
                for(var i = 0;i<sibling.length;i++){
                    var oldParent=ui.item.siblings('[data-item='+index+']');
                    oldParent.attr('data-item',oldParent.index());
                    index=oldParent.index();
                }
                parent.attr('data-item',parent.index());
                ui.item.attr('data-parent',parent.index());
                ui.item.attr('data-item',ui.item.index());
            }else{
                ui.item.removeAttr('data-parent');
            }
            if (ui.item.index() != 0) {
                classBootstrap = 'col-md-offset-' + classDeptch;
                ui.item.addClass(classBootstrap);
                var dataDepth = ui.item.data('depth');
                ui.item.attr('data-depth', (classDeptch));
            }
            var fullId=extId+'-'+ ui.item.attr('data-item');
            ui.item.attr('id',fullId);
        }
    }).disableSelection();

    $(".sortable-ui").on('click','.wells .del',function(){
        $(this).parent('.wells').remove()
    });


    $(".sortable-ui").on('click','.wells .showInput',function(){
        var input =$(this).siblings('p.form-group');
        if(input.hasClass('hide')){
            input.slideDown(300);
            input.removeClass('hide');
            $(this).removeClass('glyphicon-chevron-down');
            $(this).addClass('glyphicon-chevron-up');
        }else{
            input.slideUp(300);
            input.addClass('hide');
            $(this).addClass('glyphicon-chevron-down');
            $(this).removeClass('glyphicon-chevron-up');
        }
    });
    $(".sortable-ui").on('click','.wells .showDropFile',function(e){
        e.preventDefault();
        $("#dropFileHide").hide();
        var url = $(this).data('url');
        var id = $(this).parents('li.wells').attr('data-item');
        var className = $(this).parents('li.wells').attr('data-model');
        var extId=$(this).parents('ul').attr('data-class');
        var fullId=extId+'-'+id;
        $.ajax({
            type: "GET",
            url:url,
            data:"id="+fullId+"&className="+className,
            success: function(data){
                $(".dropFileHide").html(data);
                $(".dropFileHide").show();
                //$("#menuget-imagefile").dropzone({url:url});
            }
        });
    });
    $.fn.hasAttr = function(name) {
        return this.attr(name) !== undefined;
    };
    $('#formMenu').on('beforeSubmit', function (ev) {
        var menu = {};
        var menuExt = {};
        var extra = {};
        var menus = {};
        var count = 1;
        $("#menu-to-edit li").each(function (i) {
            var keyMenus=$(this).parents('ul').data('class');
            if ($(this).data('menu')) {
                var menuItem = $(this).data('menu');
                var depth = parseInt($(this).attr('data-depth'));
                var item = $(this).attr('data-item');
                var text = $(this).attr('data-title');
                var key = 'menu' + $(this).attr('data-item'); if ($(this).find('.tilteInput').val().length == 0) {
                    title = $(this).data('title').toString();
                } else {
                    title = $(this).find('.tilteInput').val();
                }
                if ($(this).find('.classInput').val().length == 0) {
                    classItem = false;
                } else {
                    classItem = $(this).find('.classInput').val();
                }
                if ($(this).find('.idInput').val().length == 0) {
                    idInput = false;
                } else {
                    idInput = $(this).find('.idInput').val();
                }
                if ($(this).find('.aliasInput').val().length == 0) {
                    aliasInput = false;
                } else {
                    aliasInput = $(this).find('.aliasInput').val();
                }
                var addmenu = {menuItem: menuItem, depth: depth,item:item,text:text,classItem:classItem,idInput:idInput,aliasInput:aliasInput}

            } else {

                var model = $(this).data('model');
                var alias = $(this).data('alias');
                var depth = parseInt($(this).attr('data-depth'));
                var path = $(this).data('path');
                var title = '';
                if ($(this).find('img')) {
                    var img = $(this).find('img');
                    var imgPath = img.attr('data-pathimage');
                    var imgName = img.attr('data-filename');
                } else {
                    var imgPath = false;
                    var imgName = false;
                }
                if ($(this).find('.tilteInput').val().length == 0) {
                    title = $(this).data('title').toString();
                } else {
                    title = $(this).find('.tilteInput').val();
                }
                if ($(this).find('.classInput').val().length == 0) {
                    classItem = false;
                } else {
                    classItem = $(this).find('.classInput').val();
                }
                if ($(this).find('.idInput').val().length == 0) {
                    idInput = false;
                } else {
                    idInput = $(this).find('.idInput').val();
                }
                var key = 'menu' + $(this).attr('data-item');

                var addmenu = {
                    title: title,
                    model: model,
                    alias: alias,
                    depth: depth,
                    path: path,
                    classItem:classItem,
                    idInput:idInput,
                    imgPath: imgPath,
                    imgName: imgName
                };

            }
            if ($(this).attr('data-parent')) {
                var parentKey = 'menu' + $(this).data('parent');
                var parent = menu[parentKey];
                if (parent) {
                    for (var j = depth; j > 1 && parent; j--) {
                        parent = parent.depthMenu;
                    }
                    if (parent) {
                        if (typeof parent.depthMenu == "undefined") {
                            parent.depthMenu = {};
                        }
                        parent.depthMenu[key] = addmenu;
                    }
                } else {
                    menu[key] = addmenu;
                }
            } else {
                menu[key] = addmenu;
            }
            menus[keyMenus]=menu;
        });

        $('.extra').each(function () {
            if($(this).children("li").length!=0) {
                var keyExtra = $(this).attr('data-class');
                $(this).children("li").each(function (i) {
                    if ($(this).data('menu')) {
                        var menuItem = $(this).data('menu');
                        var depth = parseInt($(this).attr('data-depth'));
                        var item = $(this).attr('data-item');
                        var text = $(this).attr('data-title');
                        var key = 'menu' + $(this).attr('data-item');
                        if ($(this).find('.tilteInput').val().length == 0) {
                            title = $(this).data('title').toString();
                        } else {
                            title = $(this).find('.tilteInput').val();
                        }
                        if ($(this).find('.classInput').val().length == 0) {
                            classItem = false;
                        } else {
                            classItem = $(this).find('.classInput').val();
                        }
                        if ($(this).find('.idInput').val().length == 0) {
                            idInput = false;
                        } else {
                            idInput = $(this).find('.idInput').val();
                        }
                        if ($(this).find('.aliasInput').val().length == 0) {
                            aliasInput = false;
                        } else {
                            aliasInput = $(this).find('.aliasInput').val();
                        }
                        var addmenuExt = {menuItem: menuItem, depth: depth,item:item,text:text,classItem:classItem,idInput:idInput,aliasInput:aliasInput}
                    } else {
                        var model = $(this).data('model');
                        var alias = $(this).data('alias');
                        var depth = parseInt($(this).attr('data-depth'));
                        var path = $(this).data('path');
                        var title = '';
                        if ($(this).find('img')) {
                            var img = $(this).find('img');
                            var imgPath = img.attr('data-pathimage');
                            var imgName = img.attr('data-filename');
                        } else {
                            var imgPath = false;
                            var imgName = false;
                        }
                        if ($(this).find('.tilteInput').val().length == 0) {
                            title = $(this).data('title').toString();
                        } else {
                            title = $(this).find('.tilteInput').val();
                        }
                        if ($(this).find('.classInput').val().length == 0) {
                            classItem = false;
                        } else {
                            classItem = $(this).find('.classInput').val();
                        }
                        if ($(this).find('.idInput').val().length == 0) {
                            idInput = false;
                        } else {
                            idInput = $(this).find('.idInput').val();
                        }
                        var key = 'munu' + $(this).attr('data-item');
                        var addmenuExt = {
                            title: title,
                            model: model,
                            alias: alias,
                            depth: depth,
                            path: path,
                            classItem:classItem,
                            idInput:idInput,
                            imgPath: imgPath,
                            imgName: imgName
                        };
                    }
                    if ($(this).attr('data-parent')) {
                        var parentKey = 'menu' + $(this).data('parent');
                        var parent = menuExt[parentKey];
                        if (parent) {
                            for (var j = depth; j > 1 && parent; j--) {
                                parent = parent.depthMenu;
                            }
                            if (parent) {
                                if (typeof parent.depthMenu == "undefined") {
                                    parent.depthMenu = {};
                                }
                                parent.depthMenu[key] = addmenuExt;
                            }
                        } else {
                            menuExt[key] = addmenuExt;
                        }
                    } else {
                        menuExt[key] = addmenuExt;
                    }
                });
                menus[keyExtra] = menuExt;
            }
        });
        console.log(JSON.stringify(menus, "", 4));
        var nameInput = $('#menu-to-edit').attr('data-name');
        var pathForm = $('#formMenu').attr('action');
        var inputTitle = $('#menuget-key_setup');
        var inputTitleName = inputTitle.attr('name');
        var inputTitleVal = inputTitle.val();
        var oData = new FormData(document.getElementById('formMenu'));
        oData.append(inputTitleName,inputTitleVal);
        oData.append(nameInput, JSON.stringify(menus, "", 4));
        if($('#secures').hasAttr('data-nameservicefield')){
            var servicefield=$('#secures').data('servicefield');
            var nameservicefield = $('#secures').data('nameservicefield')
            oData.append(servicefield,nameservicefield);
        }
        var oReq = new XMLHttpRequest();
        oReq.open("POST",pathForm,true);
        oReq.send(oData);
        var path = $('#secures').data('formurl');
        window.location.assign('http://'+window.location.hostname+path);
        return false;
    });
});

if($('li').is('.wells')){
    var maxLi=0;
    $("#menu-to-edit li").each(function (){
        maxLi=Math.max(maxLi,parseInt($(this).attr('data-item')));
    });
    var count=maxLi+1;
}else{
    var count=0;
}


function log (evt) {
    if (!evt) {
        var args = '{}';
    } else {
        var args = evt.params;
    }
    return args;}
