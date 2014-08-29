<fieldset>
    <div class="panel">
        <div class="panel-heading">
            <legend><i class="icon-info"></i> {l s='Comment on product' mod='mymodcomments'}</legend>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='ID:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->id}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Firstname:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->firstname}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Lastname:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->lastname}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='E-mail:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{if $admin_customer_link ne ''}<a href="{$admin_customer_link}">{/if}{$mymodcomment->email}{if $admin_customer_link ne ''}</a>{/if}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Product:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->product_name} (<a href="{$admin_product_link}"> #{$mymodcomment->id_product}</a>)</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Grade:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->grade}/5</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Comment:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->comment|nl2br}</div>
        </div>
    </div>
</fieldset>