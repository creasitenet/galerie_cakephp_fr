<!-- Photos -->
    <?php if(isset($pictures)): ?>

        <?php foreach($pictures as $e): ?>
        
            <div class="col-sm-3">            
                <div id="picture_<?php echo $e->id; ?>">
                <div class="picture">
                    <div class="inpicture">
						<a href='pictures/getDelete/<?php echo $e->id; ?>'><i class="fa fa-times bntsup"></i></a>                   
                    </div>
                    <a href="<?php echo $e->uri(); ?>" class="fancyboxme">
                    	<img src="<?php echo $e->uri(); ?>" class="image image-responsive" />
                    </a>
                </div>
                </div>   
            </div> 

        <?php endforeach; ?>                     
           
    <?php endif; ?>
<!-- //Photos -->