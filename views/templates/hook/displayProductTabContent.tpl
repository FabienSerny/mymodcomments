<h3 class="page-product-heading">Product Comments</h3>

<div class="rte">
{foreach from=$comments item=comment}
	<p>
		<strong>Comment #{$comment.id_mymod_comment}:</strong> {$comment.comment}<br>
		<strong>Grade:</strong> {$comment.grade}/5<br>
    </p><br>
{/foreach}
</div>

{if $enable_grades eq 1 OR $enable_comments eq 1}
<div class="rte">
	<form action="" method="POST" id="comment-form">
        {if $enable_grades eq 1}
            <div class="form-group">
                <label for="grade">Grade:</label>
                <div class="row">
                    <div class="col-xs-4">
                        <select id="grade" class="form-control" name="grade">
                            <option value="0">-- Choose --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
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