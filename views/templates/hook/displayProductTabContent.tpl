<h3 class="page-product-heading" id="mymodcomments-content-tab"{if isset($new_comment_posted)} data-scroll="true"{/if}>{l s='Product Comments' mod='mymodcomments'}</h3>

<div class="rte">
{foreach from=$comments item=comment}
	<div class="mymodcomments-comment">
		<div class="star-rating"><i class="glyphicon glyphicon-star"></i> <strong>Grade:</strong></div> <input value="{$comment.grade}" type="number" class="rating" min="0" max="5" step="1" data-size="xs" />
		<div><i class="glyphicon glyphicon-comment"></i> <strong>Comment #{$comment.id_mymod_comment}:</strong> {$comment.comment}</div>
	</div>
    <hr />
{/foreach}
</div>

{if $enable_grades eq 1 OR $enable_comments eq 1}
<div class="rte">
	<form action="" method="POST" id="comment-form">
        {if $enable_grades eq 1}
            <div class="form-group">
                <label for="grade">Grade:</label>
                <div class="row">
                    <div class="col-xs-4" id="grade-tab">
						<input id="grade" name="grade" value="0" type="number" class="rating" min="0" max="5" step="1" data-size="sm" >
				    </div>
			    </div>
		    </div>
        {/if}
        {if $enable_comments eq 1}
    		<div class="form-group">
	    		<label for="comment">Comment:</label>
		    	<textarea name="comment" id="comment" class="form-control"></textarea>
		    </div>
        {/if}
		<div class="submit">
			<button type="submit" name="mymod_pc_submit_comment" class="button btn btn-default button-medium"><span>Send<i class="icon-chevron-right right"></i></span></button>
		</div>
	</form>
</div>
{/if}