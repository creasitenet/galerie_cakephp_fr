<h2>Galerie - CakePHP 3.0</h2>

<div class="form">
<fieldset>

    <?php 
    // Ajout du css pour l'upload
    echo $this->Html->css('../plugins/fileupload/jquery.fileupload');
    // Ajout du js pour l'upload
    echo $this->Html->script('../plugins/fileupload/jquery.fileupload');
    echo $this->Html->script('../plugins/fileupload/fileupload_init');
    ?>
    
	<?php echo $this->Form->create(); ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <div id="fileupload">
            <div id="fileupload_loader"></div>
            <span class="message">Glissez vos photos ici (ou cliquez) <br /><small> 1mo 1024x1024px</small></span>
            <center><input class="file-upload" type="file" name="fileup" /></center>
        </div>
	<?php echo $this->Form->end(); ?>
    
</fieldset>
<div class="clearfix"></div>
</div>

<div id='pictures'>
	<div class="row">
    <?php if(isset($pictures)): ?>    
        <?php //echo render('galerie/_pictures'); ?>
        <?php include('_pictures.ctp'); ?>
    <?php endif; ?>
    </div>
</div>

	