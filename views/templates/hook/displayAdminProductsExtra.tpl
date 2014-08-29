<div class=" product-tab-content" id="product-tab-content-mymodcomments" style="display: block;">
	<div class="panel product-tab" id="product-mymodcomments">
		<h3 class="tab"> <i class="icon-info"></i> {l s='Product Comments' mod='mymodcomments'}</h3>

		<table style="width:100%">
			<thead>
			<tr>
				<th>{l s='ID' mod='mymodcomments'}</th>
				<th>{l s='Author' mod='mymodcomments'}</th>
				<th>{l s='E-mail' mod='mymodcomments'}</th>
				<th>{l s='Grade' mod='mymodcomments'}</th>
				<th>{l s='Comment' mod='mymodcomments'}</th>
				<th>{l s='Date' mod='mymodcomments'}</th>
			</tr>
			</thead>
			<tbody>
            {foreach from=$comments item=comment}
			<tr>
				<td>#{$comment.id_mymod_comment}</td>
				<td>{$comment.firstname} {$comment.lastname}</td>
				<td>{$comment.email}</td>
				<td>{$comment.grade}/5</td>
				<td>{$comment.comment}</td>
				<td>{$comment.date_add}</td>
			</tr>
            {/foreach}
			</tbody>
		</table>

        {if $nb_pages gt 1}
            <ul class="pagination">
            {for $count=1 to $nb_pages}
                {if $page ne $count}
                    <li><a class="comments-pagination-link" href="{$ajax_action_url}&configure=mymodcomments&ajax_hook=displayAdminProductsExtra&id_product={$smarty.get.id_product}&page={$count}"><span>{$count}</span></a></li>
                {else}
                    <li class="active current"><span><span>{$count}</span></span></li>
                {/if}
            {/for}
            </ul>
            <script type="text/javascript" src="{$pc_base_dir}views/js/mymodcomments-backoffice-product.js"></script>
        {/if}

    </div>
</div>

