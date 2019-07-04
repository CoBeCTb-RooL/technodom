<?App\Lib\State::layout('main')?>

<script>

</script>


<div id="products">
    <h1>Товары <span v-if="loading"><img src="public/assets/images/preloader.gif" width="32" alt=""></span></h1>
<!--    <p>-->
<!--    <button type="button" onclick="Products.list(); ">&nbsp;</button>-->
    <div  class="container-fluid">

        <div v-if="list.length>0">
            <div v-if="!firstLoad">
                Товаров: <b>{{list.length}}</b>
                <table  class="table table-hover ">
                    <thead>
                    <tr>
                        <th style="max-width: 60px; "></th>
                        <th>id</th>
                        <th >Название</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>SKU</th>
                        <th style="color: #df0000; ">Удалить</th>
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
                        <td class="justify-center"><input type="checkbox" :name="'delete['+item.id+']'"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else>Товаров нет.</div>

    </div>

    <button class="btn btn-success" type="button" onclick="Products.edit(); ">+ добавить</button>

</div>





<!-- Modal -->
<div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Modal title</h5>
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
        // app.loading = false
    })

</script>