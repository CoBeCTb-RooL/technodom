<?php
$item = $MODEL['item'];
$cats = $MODEL['cats'];
//vd($item);
//vd($item);
//vd($cats);
?>




<form id="editFormWrapper" onsubmit="Products.editSubmit(); return false;  ">
    <input type="hidden" name="id" value="<?=$item ? $item->id : ''?>" >
    <input type="submit" name="aaa" style="display: none; ">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Название:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control " name="title" placeholder="Название" v-model="item.title">
                    <div class="error-label"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Категория:</label>
                <div class="col-sm-9">
                    <select v-model="item.categoryId" class="custom-select" name="categoryId" onchange="Products.catPropsHtml($(this).val()); " >
                        <option value="">-выберите-</option>
                        <?foreach ($cats as $cat):?>
                        <option  value="<?=$cat->id?>" ><?=$cat->title?></option>
                        <?endforeach;?>
                    </select>
                    <div class="error-label"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">SKU:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sku" placeholder="SKU" v-model="item.sku">
                    <div class="error-label"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Цена:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="price" placeholder="Цена" v-model="item.price">
                    <div class="error-label"></div>
                </div>
            </div>
<!--            <input type="text" v-model="item.props[1]" >-->
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-6" id="props">
            <!--!!!-->
        </div>
    </div>



</form>


<script>

    //  инишиейтор инфы существующих товаров в форме
    var vueEditFormApp = new Vue({
        el: '#editFormWrapper',
        data: {
            item: <?=$item ? json_encode($item) : '{}'?>
        },
    })

    //  вешаем хэндлер, чтобы при изменении полей, маркировка проблемы исчезала
    Products.setListenersOnInputsToClearOnChange()


    <?if($item):?>
    Products.catPropsHtml(<?=$item->categoryId?>);
    <?endif;?>
</script>
