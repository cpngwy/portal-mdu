<?php if(isset($errors) || isset($error)):?>

        <?php if(is_array($errors)):?>
       
            <div class="card mb-4 bg-danger text-white shadow animated--fade-in">
                <div class="card-body">
                    Warning
                    <?php foreach($errors as $error):?>
                    <div class="text-white-50 medium"><?php echo $error;?></div>
                    <?php endforeach?>
                </div>
            </div>
       
        <?php else: ?>

            <div class="card mb-4 bg-danger text-white shadow animated--fade-in">
                <div class="card-body">
                    Warning
                    <div class="text-white-50 medium"><?php echo $error;?></div>
                </div>
            </div>
-
        <?php endif;?>

<?php elseif($message):?>
    
    <div class="card mb-4 bg-success text-white shadow animated--fade-in">
        <div class="card-body">
            Success
            <div class="text-white-50 medium"><?php echo $message;?></div>
        </div>
    </div>

<?php endif;?>