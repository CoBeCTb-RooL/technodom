<?php
$cat = $MODEL['cat'];
$item = $MODEL['product'];
?>


<?if($cat):?>
    <?if(count($cat->props())):?>
        <?foreach ($cat->props() as $prop):?>
        <?
        $propName = $prop->code;
        ?>
            <div class="form-group row ">
                <label class="col-sm-3 col-form-label"><?=$prop->title?>:</label>
                <div class="col-sm-8 pr-0">
                    <input type="text" v-model="item.<?=$propName?>" class="form-control" name="<?=$propName?>" placeholder="<?=$prop->title?>" value="<?=$item->$propName?>">
                    <div class="error-label"></div>
                </div>
                <label class="col-sm-1 col-form-label ml-0 pl-1 align-middle" ><?=$prop->unit?></label>
            </div>
        <?endforeach;?>
    <?endif?>
<?endif;?>


<script>
    //  вешаем ЕЩЁ РАЗ хэндлер, чтобы при изменении полей, маркировка проблемы исчезала
    //  ДЛЯ НОВЫХ ПОЛЕЙ
    Products.setListenersOnInputsToClearOnChange()
</script>




