var Products = {
    currentProductId: 0,
    list: function(){
        $.ajax({
            url: '/products/listJson',
            dataType: 'json',
            beforeSend: function(){app.loading = true; $('#products .container-fluid').css('opacity', .4); },
            complete: function(){ app.loading = false; app.firstLoad = false; $('#products .container-fluid').css('opacity', 1); },
            success: function(data){
                app.list = data.list
            },
            error: function(){},
        })
    },


    edit: function(id){
        id = id || null
        this.currentProductId = id
        $('#editModal .modal-title b').html(id ? 'Редактирование товара' : 'Добавление товара')

        $('#editModal').modal({})

        $.ajax({
            url: '/products/editForm',
            data: {id:id},
            dataType: '',
            beforeSend: function(){$('#editModal .modal-body').html('Загрузка...'); app.loading = true;  },
            complete: function(){ app.loading = false; },
            success: function(data){
                $('#editModal .modal-body').html(data)
            },
            error: function(){},
        })

    },

    catPropsHtml: function(catId){
        $.ajax({
            url: '/products/editFormPropsPartial',
            data: {catId:catId, productId: this.currentProductId},
            dataType: '',
            beforeSend: function(){ $('#editModal .modal-body #props').html('Загрузка...'); app.loading = true;  },
            complete: function(){  app.loading = false;  },
            success: function(data){
                $('#editModal .modal-body #props').html(data)
            },
            error: function(){},
        })
    },



    editSubmit: function(){
        $.ajax({
            url: '/products/editFormSubmit',
            data: $('#editFormWrapper').serialize(),
            dataType: 'json',
            beforeSend: function(){$('#editModal .loading').show(); Products.cleanProblems()  },
            complete: function(){  $('#editModal .loading').hide();  },
            success: function(data){
                if(data.result == 'ok'){
                    toastr.success('Сохранено!')
                    $('#editModal').modal('hide')
                    Products.list();
                }
                else{
                    Products.showProblems(data.problems)
                    toastr.error(data.error || 'Необходимо заполнить все поля корректно!')
                }
            },
            error: function(){toastr.error('Возникла ошибка на сервере.. Обратитесь к разработчику')},
        })
    },


    setListenersOnInputsToClearOnChange: function(){
        $('#editFormWrapper input, #editFormWrapper select ').on('change keypress', function() {
            $(this).removeClass('is-invalid')
            $(this).parent().find('.error-label').slideUp('fast')
        });
    },

    showProblems: function(problems){
        var form = $('#editFormWrapper')
        $.each(problems, function(k, v){
            $(form).find('input[name='+v.field+'], select[name='+v.field+']').addClass('is-invalid')
            $(form).find('input[name='+v.field+'], select[name='+v.field+']').parent().find('.error-label').html(v.msg).hide().slideDown('fast')
        })
    },
    cleanProblems: function(){
        var form = $('#editFormWrapper')
        $(form).find('input, select').removeClass('is-invalid')
        $(form).find('input, select').parent().find('.error-label').slideUp('fast')
    },


    deleteSelected: function(){
        var $checked = $('#products input[name^=delete]:checked')
        if($checked.length){
            var data = []
            $.each($checked, function(k, v){
                data.push($(v).attr('productId'))
            })

            $.ajax({
                url: '/products/deleteByIds',
                data: {ids: data},
                dataType: 'json',
                beforeSend: function(){ app.loading = true;  $('#products .container-fluid').css('opacity', .4);},
                complete: function(){  app.loading=false; $('#products .container-fluid').css('opacity', 1); },
                success: function(data){
                    toastr.success('Сохранено!')
                    if(data.errors.length > 0){
                        for(var i in data.errors)
                            toastr.error(data.errors[i])
                    }
                    if(data.warnings.length > 0){
                        for(var i in data.warnings)
                            toastr.warning(data.warnings[i])
                    }
                    if(data.result == 'ok')
                        Products.list();
                },
                error: function(){toastr.error('Возникла ошибка на сервере.. Обратитесь к разработчику')},
            })

        }
    }


}