<?App\Lib\State::layout('main')?>

<script>

</script>


<div id="products">
    <h1>Товары <span v-if="loading"><img src="public/assets/images/preloader.gif" width="32" alt=""></span></h1>
    <div  class="container-fluid">

            <div v-if="list.length>0">
                <div v-if="!firstLoad">
                    Товаров: <b>{{list.length}}</b>
                    <table  class="table table-hover products-tbl">
                        <thead>
                        <tr>
                            <th style="max-width: 60px; "></th>
                            <th>id</th>
                            <th >Название</th>
                            <th>Категория</th>
                            <th>Цена</th>
                            <th>SKU</th>
                            <th>Хар-ки</th>
                            <th style="color: #df0000; "><label ><input type="checkbox" onclick="$('#products input[name^=delete]').prop('checked', $(this).is(':checked') ? true : false); "> Удалить </label></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="item " v-for="item in list" v-on:dblclick="Products.edit(item.id)">
                            <td >
                                <button class="btn btn-warning btn-sm"  v-on:click="Products.edit(item.id)">ред.</button>
                            </td>
                            <td>{{item.id}}</td>
                            <td>{{item.title}}</td>
                            <td >
                                <span v-if="item.category">{{item.category.title}} <sup>[{{item.category.code}}]</sup></span>
                                <span v-else style="color: #888; " >-нет-</span>
                            </td>
                            <td>{{item.price}}</td>
                            <td>{{item.sku}}</td>
                            <td class="props">
                                <div v-for="prop in item.props">
                                    <b>{{prop.title}}</b>: {{item[prop.code]}}{{prop.unit}}
                                </div>
                            </td>
                            <td class="justify-center"><input type="checkbox" :name="'delete['+item.id+']'" :productId="item.id" ></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else>Товаров нет.</div>

        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-success" type="button" onclick="Products.edit(); ">+ добавить</button>
                <button class="btn btn-danger float-sm-right" type="button" onclick="if(confirm('Вы уверены?')){Products.deleteSelected();} ">удалить выбранные</button>
            </div>
        </div>

    </div>



</div>





<!-- Modal -->
<div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" ><b>Modal title</b> <img src="public/assets/images/preloader.gif" class="loading" width="24" alt="" style="display: none; "></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Загрузка...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="$('#editFormWrapper').submit(); ">Сохранить</button>
            </div>
        </div>
    </div>
</div>







<script>
    var app = new Vue({
        el: '#products',
        data: {
            firstLoad: true,
            loading: true,
            list: [

            ],
        }
    })



    $(document).ready(function(){
        Products.list()
    })

</script>