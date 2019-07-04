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
        $('#editModal .modal-title').html(id ? 'Редактирование товара' : 'Добавление товара')

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
            beforeSend: function(){/*vueEditFormApp.item.props=[9,9,9];*/ $('#editModal .modal-body #props').html('Загрузка...'); app.loading = true;  },
            complete: function(){  app.loading = false;  },
            success: function(data){
                $('#editModal .modal-body #props').html(data)
            },
            error: function(){},
        })
    },



    editSubmit: function(){
        // var form = $('#editFormWrapper')
        // $.each($(form).find('input:visible, select:visible'), function(k, v){
        //     alert($(v).attr('name')+' = '+$(v).val())
        // })
        $.ajax({
            url: '/products/editFormSubmit',
            // data: vueEditFormApp.item,
            data: $('#editFormWrapper').serialize(),
            dataType: '',
            beforeSend: function(){app.loading = true;  },
            complete: function(){  app.loading = false;  },
            success: function(data){
                if(data.result == 'ok'){
                    alert('ok!')
                }
                else
                    Products.showProblems(data.problems)
            },
            error: function(){},
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
        $(form).find('input[name=' + v.field + '], select[name=' + v.field + ']').removeClass('is-invalid')
        $(form).find('input[name=' + v.field + '], select[name=' + v.field + ']').parent().find('.error-label').html(v.msg).slideUp('fast')
    }


}