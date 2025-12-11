<?php if($paginator->hasPages()): ?>
    <nav>
        <ul class="pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span aria-hidden="true">上一页</span>
                </li>&nbsp;
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->previousPageUrl(), false); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">上一页</a>
                </li>&nbsp;
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="disabled" aria-disabled="true"><span><?php echo e($element, false); ?></span></li>&nbsp;
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="active" aria-current="page"><span><?php echo e($page, false); ?></span></li>&nbsp;
                        <?php else: ?>
                            <li><a href="<?php echo e($url, false); ?>"><?php echo e($page, false); ?></a></li>&nbsp;
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->nextPageUrl(), false); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">下一页</a>
                </li>&nbsp;
            <?php else: ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span aria-hidden="true">下一页</span>
                </li>&nbsp;
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/vendor/pagination/default.blade.php ENDPATH**/ ?>