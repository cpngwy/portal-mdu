<?php if(isset($errors) || isset($error)):?>

        <?php if(is_array($errors) || is_object($errors)):?>
                <div class="card mb-4 bg-danger text-white shadow" id="card-message">
                    <div class="card-body">
                        Warning
                        <?php foreach($errors as $error):?>

                            <?php if(is_object($error)):?>
                                
                                <?php foreach($error as $key => $value):?>
                                    <?php if(!empty($value)):?>
                                    <div class="text-white-50 medium"><?php echo $value;?></div>
                                    <?php endif;?>
                                <?php endforeach?>
                            
                            <?php else:?>
                            
                                <div class="text-white-50 medium"><?php echo $error;?></div>
                            
                            <?php endif;?>

                        <?php endforeach?>
                    </div>
                </div>

        <?php else: ?>

            <div class="card mb-4 bg-danger text-white shadow" id="card-message">
                <div class="card-body">
                    Warning
                    <div class="text-white-50 medium"><?php echo $error ?? 'something went wrong';?></div>
                </div>
            </div>
-
        <?php endif;?>

<?php elseif($message):?>
    
    <div class="card mb-4 bg-success text-white shadow" id="card-message">
        <div class="card-body">
            Success
            <div class="text-white-50 medium"><?php echo $message;?></div>
        </div>
    </div>

<?php endif;?>